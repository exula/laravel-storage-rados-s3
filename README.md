#Laravel Rados Gateway S3 storage provider
___
This is  a simple service provider that extends league/flysystem-aws-s3-v3 and allows the base_url to be set.

Primary use is for S3 compatible services like the [Ceph Rados Gateway](http://docs.ceph.com/docs/master/radosgw/s3/)

___

## Installation

```bash
composer require exula/laravel-storage-rados-s3
```
Package should be auto discovered by Laravel 5.5

OR

Register the service provider in app.php
```php
'providers' => [
    // ...
    Exula\Ceph\CephStorageServiceProvider::class,
]
```

Add a new disk to your `config/filesystems.php` config:
 ```php
'ceph' => [
            'base_url' => env('CEPH_BASE_URL', 'xxxxxxxxx'),
            'driver' => 'ceph',
            'key' => env('CEPH_ACCESS_KEY', 'xxxxxxx'),
            'credentials' => [
                'key' => env('CEPH_ACCESS_KEY', 'xxxxxxx'),
                'secret' => env('CEPH_SECRET_KEY', 'xxxxxxx'),
                ],
            'region' => '',
            'bucket' => env('CEPH_BUCKET', 'test'),
            'version' => env('CEPH_VERSION', 'latest'),
            'ACL' => env('CEPH_ACL', 'private'), //private,'public-read',
            'visibility' => env('CEPH_VISIBILITY', 'private')
        ],
```


Put the following lines in your `.env` file and fill out with your connection information
```
CEPH_BASE_URL=
CEPH_ACCESS_KEY=
CEPH_SECRET_KEY=
CEPH_BUCKET=
CEPH_VERSION=
CEPH_ACL=
CEPH_VISIBILITY=

```


## Usage
Once installed this can be used as any standard Storage driver for Laravel 5.5
https://laravel.com/docs/5.5/filesystem
