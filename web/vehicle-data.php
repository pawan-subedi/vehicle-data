<?php
ini_set('max_execution_time', 0); //There is a lot of fetching to be done. Lets not kill the script

require_once(dirname(__FILE__) . '/response/series.php');
require_once(dirname(__FILE__) . '/response/response.php');
require_once(dirname(__FILE__) . '/cache/RedisAdapter.php');
require_once(dirname(__FILE__) . '/classes/Make.php');
require_once(dirname(__FILE__) . '/classes/Manufacturer.php');
$startYear = '1950';
$endYear = '2000';

//========================================================
//======================URLS==============================
//========================================================

$allMakes = "https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json";
$allManufacturers = "https://vpic.nhtsa.dot.gov/api/vehicles/getallmanufacturers?format=json";

$getMakesByManufacturerYear = "https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForManufacturerAndYear/%s?year=%s&format=json";
$getModelsByMakesYear = "https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMakeIdYear/makeId/%s/modelyear/%s?format=json";

$getMakeDetails = "https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMakeIdYear/makeId/%s/modelyear/%s?format=json";
$getMakeDetailsByModel = "https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeyear/make/%s/modelyear/%s?format=json";
$currentYear = $startYear - 1;

$curl = curl_init();

$graphSeries = new Response();
$cache = new RedisAdapter();
$averageCounter = array();
$cacheKey = "ALL_MANUFACTURERS";
//$cache->flushAll();
if ($cache->get($cacheKey)) {
    $response = $cache->get($cacheKey);
    $response = json_decode($response, true);
} else {
    //Get All Manufacturers
    curl_setopt($curl, CURLOPT_URL, $allManufacturers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    if ($response) {
        $cache->set($cacheKey, $response);
        $response = json_decode($response, true);
    } else {
        die('Cannot connect to API');
    }
}
$manufacturers = array();
foreach ($response['Results'] as $manufacturer) {
    $manufacturers[$manufacturer['Mfr_ID']] = Manufacturer::Decode($manufacturer);
}


while ($currentYear++ < $endYear) {
    foreach ($manufacturers as $manufacturerId => $details) {
        if (!isset($averageCounter[$details->getMfrID()])) {
            $averageCounter[$details->getMfrID()]['Total'] = 0;
            $averageCounter[$details->getMfrID()]['Years'] = 0;
        }

        $series = $graphSeries->findSeries($details);

        $cacheKey = $details->getMfrID() . '|' . $currentYear;

        if ($cache->get($cacheKey)) {
            $response = $cache->get($cacheKey);
        } else {
            curl_setopt($curl, CURLOPT_URL, sprintf($getMakesByManufacturerYear, $details->getMfrID(), $currentYear));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
            $cache->set($cacheKey, $response);
        }
        $response = json_decode($response, true);
        $count = 0;

        foreach ($response['Results'] as $make) {
            $cacheKey = $details->getMfrID() . '|' . $make['MakeId'] . '|' . $currentYear;
            if ($cache->get($cacheKey)) {
                $responseDetail = $cache->get($cacheKey);
            } else {
                curl_setopt($curl, CURLOPT_URL, sprintf($getModelsByMakesYear, $make['MakeId'], $currentYear));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $responseDetail = curl_exec($curl);
                $cache->set($cacheKey, $responseDetail);
            }

            $responseDetail = json_decode($responseDetail, true);

            if ($responseDetail) {
                $count += $responseDetail['Count'];

                $averageCounter[$details->getMfrID()]['Total'] += $count;
                $averageCounter[$details->getMfrID()]['Years']++;
            }

        }
        $series->pushData(new Data($currentYear, $count == 0 ? null : $count));
    }

}
$hold = true;

uasort($averageCounter, function ($a, $b) {
    if ($a['Total'] == $b['Total']) {
        return 0;
    }
    return ($a['Total'] < $b['Total']) ? 1 : -1;
});
$topTen = array_keys(array_slice($averageCounter, 0, 10, true));
//We have a lot of series. We are only going to show top 10 makes by default
foreach ($graphSeries->getSeries() as $series) {
    if (in_array($series->getId(), $topTen)) {
        $series->setVisible(true);
    }
}

$json = json_encode($graphSeries);
curl_close($curl);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div id="container" style="height: 100%; width: 100%"></div>
<script>
    Highcharts.chart('container', {


        title: {
            text: 'Cars Produced by manufacturer'
        },

        subtitle: {
            text: 'Source: United States Department of Transportation'
        },

        yAxis: {
            title: {
                text: 'Number of Vehicles'
            },
            scrollbar: {
                enabled: true
            },
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Year'
            },
            scrollbar: {
                enabled: true
            },
            max: <?= $endYear ?>
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: <?= $startYear ?>
            }
        },
        series: <?= $json ?>,

        responsive: {
            rules: [{
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
    $(document).on('click', '.rebuild-data', function () {
        alert('Hello');
    })
</script>

