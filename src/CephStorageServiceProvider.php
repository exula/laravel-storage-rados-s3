<?php

namespace Exula\LaravelFilesystem\Ceph;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;



class CephStorageServiceProvider extends ServiceProvider
{
    const CEPH_BASE_URL = 'https://s3.aws.com';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Storage::extend('ceph', function ($app, $config) {
            $config['endpoint'] = isset($config['base_url']) ? $config['base_url'] : self::CEPH_BASE_URL;
            $config['use_path_style_endpoint'] = true;
            $client = new S3Client($config);

            return new Filesystem(new AwsS3Adapter($client, $config['bucket']));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

