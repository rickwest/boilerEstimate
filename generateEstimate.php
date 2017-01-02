<?php

//combi boiler prices
$combi24 = 1094.48;
$combi28 = 1258.91;
$combi33 = 1394.66;
$combi40 = 1468.89;

//heat only/system boiler prices
$heat12 = 948.76;
$heat15 = 950.90;
$heat18 = 1077.07;
$heat24 = 1130.15;
$heat30 = 1169.41;

//labour prices
$boilerSwap = 500;
$conversion = 700;
$bbuConversion = 850;

$relocateBoiler = 200;

//install components
$verticalFlue = 200;
$brickUpBalancedFlue = 50;
$fitTRV = 30;
$stdControls = 100;
$smartStat = 200;

//vat registered
$vatRegistered = true;

//get form results
$numberOfBedrooms = $_POST['numberOfBedrooms'];
$exitingBoilerType = $_POST['existingBoilerType'];
$existingFlueType = $_POST['existingFlueType'];
$newBoilerType = $_POST['newBoilerType'];
$newBoilerLocation = $_POST['newBoilerLocation'];
$newFlueType = $_POST['newFlueType'];
$valvesRequired = $_POST['valvesRequired'];
$numberOfValves = $_POST['numberOfValves'];
$newControls = $_POST['newControls'];
$smartControls = $_POST['smartControls'];

$summary = [];
$total = 0;

//get size of new boiler depending on number of bedrooms
switch ($numberOfBedrooms) {
    case '1':
        if($newBoilerType == 'combi'){
            $summary['boilerCost'] = $combi24;
            $total += $combi24;
        } else if ($newBoilerType == 'heatOnly') {
            $summary['boilerCost'] = $heat12;
            $total += $heat12;
        } else {}
        break;
    case '2':
        if($newBoilerType == 'combi'){
            $summary['boilerCost'] = $combi28;
            $total += $combi28;
        } else if ($newBoilerType == 'heatOnly') {
            $summary['boilerCost'] = $heat15;
            $total += $heat15;
        } else {}
        break;
    case '3':
        if($newBoilerType == 'combi'){
            $summary['boilerCost'] = $combi33;
            $total += $combi33;
        } else if ($newBoilerType == 'heatOnly') {
            $summary['boilerCost'] = $heat18;
            $total += $heat18;
        } else {}
        break;
    case '4':
        if($newBoilerType == 'combi'){
            $summary['boilerCost'] = $combi40;
            $total += $combi40;
        } else if ($newBoilerType == 'heatOnly') {
            $summary['boilerCost'] = $heat24;
            $total += $heat24;
        } else {}
        break;
    case '5+':
        if($newBoilerType == 'combi'){
            $summary['boilerCost'] = $combi40;
            $total += $combi40;
        } else if ($newBoilerType == 'heatOnly') {
            $summary['boilerCost'] = $heat30;
            $total += $heat30;
        } else {}
        break;
    default:
        break;
}

// use existing and new boiler type to find work type
if ($newBoilerType === $exitingBoilerType) {
    $summary['workType'] = $boilerSwap;
    $total += $boilerSwap;
} else if ($exitingBoilerType === 'bbu' && $newBoilerType === 'combi') {
    $summary['workType'] = $bbuConversion;
    $total += $bbuConversion;
} else {
    $summary['workType'] = $conversion ;
    $total += $conversion;
}

//check for relocation
if ($newBoilerLocation === 'relocate') {
    $summary['relocateBoiler'] = $relocateBoiler;
    $total += $relocateBoiler;
}

if ($newFlueType === 'vertical') {
    $summary['verticalFlue'] = $verticalFlue;
    $total += $verticalFlue;
}

//does old balanced flue need bricking up?
if ($existingFlueType === 'balanced' && $newBoilerType !== 'balanced') {
    $summary['brickUpExistingFlue'] = $brickUpBalancedFlue;
    $total += $brickUpBalancedFlue;
}

//calculate price for valves
if ($valvesRequired === '1') {
    $summary['costOfValves'] = $fitTRV * intval($numberOfValves);
    $total += $fitTRV * intval($numberOfValves);
}

//price for new controls
if ($newControls === '1') {
    if ($smartControls === '1') {
        $summary['controls'] = $smartStat;
        $total += $smartStat;
    } else {
        $summary['controls'] = $stdControls;
        $total += $stdControls;
    }
}

//if vat registered add 20% to total and return 20% of total as Vat amount
if ($vatRegistered) {
    $summary['vat'] = $total * 0.2;
    $total = $total * 1.2;
}

$data['summary'] = $summary;
$data['total'] = number_format($total, 2);

echo json_encode($data);
