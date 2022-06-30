<?php
$xml = simplexml_load_file(dirname(__DIR__) . '/raw/points.kml');
$fc = [
    'type' => 'FeatureCollection',
    'features' => [],
];
foreach ($xml->Document->Folder as $folder) {
    foreach ($folder->Placemark as $placemark) {
        $coordinates = explode(',', trim($placemark->Point->coordinates));
        $fc['features'][] = [
            'type' => 'Feature',
            'properties' => [
                'name' => (string)$placemark->name,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [
                    floatval($coordinates[0]),
                    floatval($coordinates[1]),
                ]
            ]
        ];
    }
}

file_put_contents(dirname(__DIR__) . '/docs/json/points.json', json_encode($fc, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
