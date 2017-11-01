1. Package should be auto discovered by Laravel 5.5

2. Add a new disk to your `config/filesystems.php` config:
 ```php
'ceph' => [
            'base_url' => env('CEPH_BASE_URL', xxxxxxxxx),
            'driver' => 'ceph',
            'key' => env('CEPH_ACCESS_KEY', 'xxxxxxx),
            'credentials' => [
            'key' => env('CEPH_ACCESS_KEY', 'xxxxxxx),
            'secret' => env('CEPH_SECRET_KEY', 'xxxxxxx),
                ],
            'region' => '',
            'bucket' => env('CEPH_BUCKET', 'test'),
            'version' => 'latest'
        ],
```