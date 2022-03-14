<?php

namespace Exula\Ceph;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;



class CephStorageServiceProvider extends ServiceProvider
{
    const CEPH_BASE_URL = 'https://s3.aws.com';
    const CEPH_VISIBILITY = 'private';
    const CEPH_PREFIX = '';
    const CEPH_DEBUG = false;
    const CEPH_ACL = 'private';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Storage::extend('ceph', function ($app, $config) {

            $config['endpoint'] = isset($config['base_url']) ? $config['base_url'] : self::CEPH_BASE_URL;

            $config['use_path_style_endpoint'] = true;
            

            $config['debug'] = isset($config['debug']) ? $config['debug'] : self::CEPH_DEBUG;;
            
            $prefix =  isset($config['prefix']) ? $config['prefix'] : self::CEPH_PREFIX;

            $options = [];

            $options['visibility'] =  isset($config['visibility']) ? $config['visibility'] : self::CEPH_VISIBILITY;

            $client = new S3Client($config);


            $options['ACL'] =  isset($config['ACL']) ? $config['ACL'] : self::CEPH_ACL;

            return new Filesystem(new AwsS3Adapter($client, $config['bucket'] , $prefix, $options ) );
        });
    }
}
