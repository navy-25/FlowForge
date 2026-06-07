<?php

return [
    'email' => [
        'label' => 'Kirim Email Otomatis',
        'description' => 'Simulasi workflow pengiriman email otomatis.',
        'definition' => [
            'nodes' => [
                [
                    'id' => 'prepare_email',
                    'type' => 'log',
                    'label' => 'Prepare Email Data',
                    'config' => [
                        'message' => 'Data email berhasil disiapkan',
                    ]
                ],
                [
                    'id' => 'validate_email',
                    'type' => 'log',
                    'label' => 'Validate Email Data',
                    'config' => [
                        'message' => 'Data email berhasil divalidasi',
                    ],
                ],
                [
                    'id' => 'send_email',
                    'type' => 'delay',
                    'label' => 'Send Email',
                    'config' => [
                        'seconds' => 10,
                    ],
                ],
                [
                    'id' => 'log_email',
                    'type' => 'log',
                    'label' => 'Log Email Result',
                    'config' => [
                        'message' => 'Email berhasil dikirim',
                    ],
                ],
            ],
            'edges' => [
                ['from' => 'prepare_email', 'to' => 'validate_email'],
                ['from' => 'validate_email', 'to' => 'send_email'],
                ['from' => 'send_email', 'to' => 'log_email'],
            ],
        ],
    ],

    // 'crawling' => [
    //     'label' => 'Crawling Data',
    //     'description' => 'Workflow mengambil data dari API, mapping data, lalu mencatat hasilnya.',
    //     'definition' => [
    //         'nodes' => [
    //             [
    //                 'id' => 'fetch_data',
    //                 'type' => 'http',
    //                 'label' => 'Fetch Data',
    //                 'config' => [
    //                     'url' => 'https://api.viproject.net/api/portfolio/all/',
    //                 ],
    //                 'fields' => [
    //                     ['name' => 'url', 'label' => 'URL', 'type' => 'text'],
    //                 ],
    //             ],
    //             [
    //                 'id' => 'save_data',
    //                 'type' => 'delay',
    //                 'label' => 'Save Data',
    //                 'config' => [
    //                     'seconds' => 1,
    //                 ],
    //                 'fields' => [],
    //             ],
    //             [
    //                 'id' => 'log_crawling',
    //                 'type' => 'log',
    //                 'label' => 'Log Crawling Result',
    //                 'config' => [
    //                     'message' => 'Data crawling berhasil diproses',
    //                 ],
    //                 'fields' => [],
    //             ],
    //         ],
    //         'edges' => [
    //             ['from' => 'fetch_data', 'to' => 'delay_node'],
    //             ['from' => 'delay_node', 'to' => 'log_crawling'],
    //         ],
    //     ],
    // ],
];
