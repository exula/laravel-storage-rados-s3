<?php

namespace Exula\Ceph;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\AwsS3V3Adapter as FilesystemAdapter;



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


            if($options['visibility'] === 'public') {
                $visibility = new \League\Flysystem\AwsS3V3\PortableVisibilityConverter(
                // Optional default for directories
                    \League\Flysystem\Visibility::PUBLIC
                );
            } else {
                $visibility = new \League\Flysystem\AwsS3V3\PortableVisibilityConverter(
                // Optional default for directories
                    \League\Flysystem\Visibility::PRIVATE
                );
            }

            $options['ACL'] =  isset($config['ACL']) ? $config['ACL'] : self::CEPH_ACL;


            $adapter =  new AwsS3V3Adapter($client, $config['bucket'] , $prefix, $visibility );


            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config,
                $client
            );

        });
    }
}
