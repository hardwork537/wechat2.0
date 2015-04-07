<?php
/**
 * Copyright 2010-2013 Sohu.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace SohuCS\Scs;

use SohuCS\Common\Client\AbstractClient;
use SohuCS\Common\Client\ClientBuilder;
use SohuCS\Common\Client\ExpiredCredentialsChecker;
use SohuCS\Common\Client\UploadBodyListener;
use SohuCS\Common\Enum\ClientOptions as Options;
use SohuCS\Common\Exception\RuntimeException;
use SohuCS\Common\Exception\InvalidArgumentException;
use SohuCS\Common\Signature\SignatureV4;
use SohuCS\Common\Model\MultipartUpload\AbstractTransfer;
use SohuCS\Scs\Exception\AccessDeniedException;
use SohuCS\Scs\Exception\Parser\ScsExceptionParser;
use SohuCS\Scs\Exception\ScsException;
use SohuCS\Scs\Model\ClearBucket;
use SohuCS\Scs\Model\MultipartUpload\AbstractTransfer as AbstractMulti;
use SohuCS\Scs\Model\MultipartUpload\UploadBuilder;
use SohuCS\Scs\Sync\DownloadSyncBuilder;
use SohuCS\Scs\Sync\UploadSyncBuilder;
use Guzzle\Common\Collection;
use Guzzle\Http\EntityBody;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Iterator\FilterIterator;
use Guzzle\Plugin\Backoff\BackoffPlugin;
use Guzzle\Plugin\Backoff\CurlBackoffStrategy;
use Guzzle\Plugin\Backoff\ExponentialBackoffStrategy;
use Guzzle\Plugin\Backoff\HttpBackoffStrategy;
use Guzzle\Plugin\Backoff\TruncatedBackoffStrategy;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Command\Factory\AliasFactory;
use Guzzle\Service\Command\Factory\CompositeFactory;
use Guzzle\Service\Resource\Model;
use Guzzle\Service\Resource\ResourceIteratorInterface;

/**
 * Client to interact with Sohu Cloud Service Service
 *
 * @method ScsSignatureInterface getSignature() Returns the signature implementation used with the client
 * @method Model abortMultipartUpload(array $args = array()) {@command Scs AbortMultipartUpload}
 * @method Model completeMultipartUpload(array $args = array()) {@command Scs CompleteMultipartUpload}
 * @method Model copyObject(array $args = array()) {@command Scs CopyObject}
 * @method Model createBucket(array $args = array()) {@command Scs CreateBucket}
 * @method Model createMultipartUpload(array $args = array()) {@command Scs CreateMultipartUpload}
 * @method Model deleteBucket(array $args = array()) {@command Scs DeleteBucket}
 * @method Model deleteBucketCors(array $args = array()) {@command Scs DeleteBucketCors}
 * @method Model deleteBucketLifecycle(array $args = array()) {@command Scs DeleteBucketLifecycle}
 * @method Model deleteBucketPolicy(array $args = array()) {@command Scs DeleteBucketPolicy}
 * @method Model deleteBucketTagging(array $args = array()) {@command Scs DeleteBucketTagging}
 * @method Model deleteBucketWebsite(array $args = array()) {@command Scs DeleteBucketWebsite}
 * @method Model deleteObject(array $args = array()) {@command Scs DeleteObject}
 * @method Model deleteObjects(array $args = array()) {@command Scs DeleteObjects}
 * @method Model getBucketAcl(array $args = array()) {@command Scs GetBucketAcl}
 * @method Model getBucketCors(array $args = array()) {@command Scs GetBucketCors}
 * @method Model getBucketLifecycle(array $args = array()) {@command Scs GetBucketLifecycle}
 * @method Model getBucketLocation(array $args = array()) {@command Scs GetBucketLocation}
 * @method Model getBucketLogging(array $args = array()) {@command Scs GetBucketLogging}
 * @method Model getBucketNotification(array $args = array()) {@command Scs GetBucketNotification}
 * @method Model getBucketPolicy(array $args = array()) {@command Scs GetBucketPolicy}
 * @method Model getBucketRequestPayment(array $args = array()) {@command Scs GetBucketRequestPayment}
 * @method Model getBucketTagging(array $args = array()) {@command Scs GetBucketTagging}
 * @method Model getBucketVersioning(array $args = array()) {@command Scs GetBucketVersioning}
 * @method Model getBucketWebsite(array $args = array()) {@command Scs GetBucketWebsite}
 * @method Model getObject(array $args = array()) {@command Scs GetObject}
 * @method Model getObjectAcl(array $args = array()) {@command Scs GetObjectAcl}
 * @method Model getObjectTorrent(array $args = array()) {@command Scs GetObjectTorrent}
 * @method Model headBucket(array $args = array()) {@command Scs HeadBucket}
 * @method Model headObject(array $args = array()) {@command Scs HeadObject}
 * @method Model listBuckets(array $args = array()) {@command Scs ListBuckets}
 * @method Model listMultipartUploads(array $args = array()) {@command Scs ListMultipartUploads}
 * @method Model listObjectVersions(array $args = array()) {@command Scs ListObjectVersions}
 * @method Model listObjects(array $args = array()) {@command Scs ListObjects}
 * @method Model listParts(array $args = array()) {@command Scs ListParts}
 * @method Model putBucketAcl(array $args = array()) {@command Scs PutBucketAcl}
 * @method Model putBucketCors(array $args = array()) {@command Scs PutBucketCors}
 * @method Model putBucketLifecycle(array $args = array()) {@command Scs PutBucketLifecycle}
 * @method Model putBucketLogging(array $args = array()) {@command Scs PutBucketLogging}
 * @method Model putBucketNotification(array $args = array()) {@command Scs PutBucketNotification}
 * @method Model putBucketPolicy(array $args = array()) {@command Scs PutBucketPolicy}
 * @method Model putBucketRequestPayment(array $args = array()) {@command Scs PutBucketRequestPayment}
 * @method Model putBucketTagging(array $args = array()) {@command Scs PutBucketTagging}
 * @method Model putBucketVersioning(array $args = array()) {@command Scs PutBucketVersioning}
 * @method Model putBucketWebsite(array $args = array()) {@command Scs PutBucketWebsite}
 * @method Model putObject(array $args = array()) {@command Scs PutObject}
 * @method Model putObjectAcl(array $args = array()) {@command Scs PutObjectAcl}
 * @method Model restoreObject(array $args = array()) {@command Scs RestoreObject}
 * @method Model uploadPart(array $args = array()) {@command Scs UploadPart}
 * @method Model uploadPartCopy(array $args = array()) {@command Scs UploadPartCopy}
 * @method waitUntilBucketExists(array $input) The input array uses the parameters of the HeadBucket operation and waiter specific settings
 * @method waitUntilBucketNotExists(array $input) The input array uses the parameters of the HeadBucket operation and waiter specific settings
 * @method waitUntilObjectExists(array $input) The input array uses the parameters of the HeadObject operation and waiter specific settings
 * @method ResourceIteratorInterface getListBucketsIterator(array $args = array()) The input array uses the parameters of the ListBuckets operation
 * @method ResourceIteratorInterface getListMultipartUploadsIterator(array $args = array()) The input array uses the parameters of the ListMultipartUploads operation
 * @method ResourceIteratorInterface getListObjectVersionsIterator(array $args = array()) The input array uses the parameters of the ListObjectVersions operation
 * @method ResourceIteratorInterface getListObjectsIterator(array $args = array()) The input array uses the parameters of the ListObjects operation
 * @method ResourceIteratorInterface getListPartsIterator(array $args = array()) The input array uses the parameters of the ListParts operation
 *
 */
class ScsClient extends AbstractClient
{
    const LATEST_API_VERSION = '2014-04-14';

    /**
     * @var array Aliases for Scs operations
     */
    protected static $commandAliases = array(
        // REST API Docs Aliases
        'GetService' => 'ListBuckets',
        'GetBucket'  => 'ListObjects',
        'PutBucket'  => 'CreateBucket',

        // SDK 1.x Aliases
        'GetBucketHeaders'              => 'HeadBucket',
        'GetObjectHeaders'              => 'HeadObject',
        'SetBucketAcl'                  => 'PutBucketAcl',
        'CreateObject'                  => 'PutObject',
        'DeleteObjects'                 => 'DeleteMultipleObjects',
        'PutObjectCopy'                 => 'CopyObject',
        'SetObjectAcl'                  => 'PutObjectAcl',
        'GetLogs'                       => 'GetBucketLogging',
        'GetVersioningStatus'           => 'GetBucketVersioning',
        'SetBucketPolicy'               => 'PutBucketPolicy',
        'CreateBucketNotification'      => 'PutBucketNotification',
        'GetBucketNotifications'        => 'GetBucketNotification',
        'CopyPart'                      => 'UploadPartCopy',
        'CreateWebsiteConfig'           => 'PutBucketWebsite',
        'GetWebsiteConfig'              => 'GetBucketWebsite',
        'DeleteWebsiteConfig'           => 'DeleteBucketWebsite',
        'CreateObjectExpirationConfig'  => 'PutBucketLifecycle',
        'GetObjectExpirationConfig'     => 'GetBucketLifecycle',
        'DeleteObjectExpirationConfig'  => 'DeleteBucketLifecycle',
    );

    protected $directory = __DIR__;

    /**
     * Factory method to create a new Amazon Scs client using an array of configuration options.
     *
     * @param array|Collection $config Client configuration data
     *
     * @return self
     * @link http://docs.aws.amazon.com/aws-sdk-php/guide/latest/configuration.html#client-configuration-options
     */
    public static function factory($config = array())
    {
        $exceptionParser = new ScsExceptionParser();

        // Configure the custom exponential backoff plugin for retrying Scs specific errors
        if (!isset($config[Options::BACKOFF])) {
            $config[Options::BACKOFF] = self::createBackoffPlugin($exceptionParser);
        }

        $config[Options::SIGNATURE] = $signature = self::createSignature($config);

        $client = ClientBuilder::factory(__NAMESPACE__)
            ->setConfig($config)
            ->setConfigDefaults(array(
                Options::VERSION => self::LATEST_API_VERSION,
                Options::SERVICE_DESCRIPTION => __DIR__ . '/Resources/scs-%s.php'
            ))
            ->setExceptionParser($exceptionParser)
            ->setIteratorsConfig(array(
                'more_key' => 'IsTruncated',
                'operations' => array(
                    'ListBuckets',
                    'ListMultipartUploads' => array(
                        'limit_param' => 'MaxUploads',
                        'token_param' => array('KeyMarker', 'UploadIdMarker'),
                        'token_key'   => array('NextKeyMarker', 'NextUploadIdMarker'),
                    ),
                    'ListObjects' => array(
                        'limit_param' => 'MaxKeys',
                        'token_param' => 'Marker',
                        'token_key'   => 'NextMarker',
                    ),
                    'ListObjectVersions' => array(
                        'limit_param' => 'MaxKeys',
                        'token_param' => array('KeyMarker', 'VersionIdMarker'),
                        'token_key'   => array('nextKeyMarker', 'nextVersionIdMarker'),
                    ),
                    'ListParts' => array(
                        'limit_param' => 'MaxParts',
                        'result_key'  => 'Parts',
                        'token_param' => 'PartNumberMarker',
                        'token_key'   => 'NextPartNumberMarker',
                    ),
                )
            ))
            ->build();

        // Use virtual hosted buckets when possible
        $client->addSubscriber(new BucketStyleListener());
        // Ensure that ACP headers are applied when needed
        $client->addSubscriber(new AcpListener());
        // Validate and add required Content-MD5 hashes (e.g. DeleteObjects)
        $client->addSubscriber(new ScsMd5Listener($signature));

        // Allow for specifying bodies with file paths and file handles
        $client->addSubscriber(new UploadBodyListener(array('PutObject', 'UploadPart')));

        // Add aliases for some Scs operations
        $default = CompositeFactory::getDefaultChain($client);
        $default->add(
            new AliasFactory($client, self::$commandAliases),
            'Guzzle\Service\Command\Factory\ServiceDescriptionFactory'
        );
        $client->setCommandFactory($default);
		
        return $client;
    }

    /**
     * Create an Amazon Scs specific backoff plugin
     *
     * @param ScsExceptionParser $exceptionParser
     *
     * @return BackoffPlugin
     */
    private static function createBackoffPlugin(ScsExceptionParser $exceptionParser)
    {
        return new BackoffPlugin(
            new TruncatedBackoffStrategy(3,
                new HttpBackoffStrategy(null,
                    new SocketTimeoutChecker(
                        new CurlBackoffStrategy(null,
                            new ExpiredCredentialsChecker($exceptionParser,
                                new ExponentialBackoffStrategy()
                            )
                        )
                    )
                )
            )
        );
    }

    /**
     * Create an appropriate signature based on the configuration settings
     *
     * @param $config
     *
     * @return ScsSignature
     * @throws InvalidArgumentException
     */
    private static function createSignature($config)
    {
        $currentValue = isset($config[Options::SIGNATURE]) ? $config[Options::SIGNATURE] : null;

        // Use the Amazon Scs signature V4 when the value is set to "v4" or when
        // the value is not set and the region starts with "cn-".
        /*if ($currentValue == 'v4' ||
            (!$currentValue && isset($config['region']) && substr($config['region'], 0, 5) == '')
        ) {
            // Force SignatureV4 for specific regions or if specified in the config
            $currentValue = new ScsSignatureV4('scs');
        } else*/
		if (!$currentValue || $currentValue == 'scs') {
            // Use the Amazon Scs signature by default
            $currentValue = new ScsSignature();
        }

        if ($currentValue instanceof ScsSignatureInterface) {
            // A region is require with v4
            if ($currentValue instanceof SignatureV4 && !isset($config['region'])) {
                throw new InvalidArgumentException('A region must be specified '
                    . 'when using signature version 4');
            }
            return $currentValue;
        }

        throw new InvalidArgumentException('The provided signature value is '
            . 'not an instance of ScsSignatureInterface');
    }

    /**
     * Determine if a string is a valid name for a DNS compatible Amazon Scs
     * bucket, meaning the bucket can be used as a subdomain in a URL (e.g.,
     * "<bucket>.s3.amazonaws.com").
     *
     * @param string $bucket The name of the bucket to check.
     *
     * @return bool TRUE if the bucket name is valid or FALSE if it is invalid.
     */
    public static function isValidBucketName($bucket)
    {
        $bucketLen = strlen($bucket);
        if ($bucketLen < 3 || $bucketLen > 63 ||
            // Cannot start or end with a '.'
            $bucket[0] == '.' || $bucket[$bucketLen - 1] == '.' ||
            // Cannot look like an IP address
            preg_match('/(\d+\.){3}\d+$/', $bucket) ||
            // Cannot include special characters, must start and end with lower alnum
            !preg_match('/^[a-z0-9][a-z0-9\-\.]*[a-z0-9]?$/', $bucket)
        ) {
            return false;
        }

        return true;
    }

    /**
     * Create a pre-signed URL for a request
     *
     * @param RequestInterface     $request Request to generate the URL for. Use the factory methods of the client to
     *                                      create this request object
     * @param int|string|\DateTime $expires The time at which the URL should expire. This can be a Unix timestamp, a
     *                                      PHP DateTime object, or a string that can be evaluated by strtotime
     *
     * @return string
     * @throws InvalidArgumentException if the request is not associated with this client object
     */
    public function createPresignedUrl(RequestInterface $request, $expires)
    {
        if ($request->getClient() !== $this) {
            throw new InvalidArgumentException('The request object must be associated with the client. Use the '
                . '$client->get(), $client->head(), $client->post(), $client->put(), etc. methods when passing in a '
                . 'request object');
        }

        return $this->signature->createPresignedUrl($request, $this->credentials, $expires);
    }

    /**
     * Returns the URL to an object identified by its bucket and key. If an expiration time is provided, the URL will
     * be signed and set to expire at the provided time.
     *
     * @param string $bucket  The name of the bucket where the object is located
     * @param string $key     The key of the object
     * @param mixed  $expires The time at which the URL should expire
     * @param array  $args    Arguments to the GetObject command. Additionally you can specify a "Scheme" if you would
     *                        like the URL to use a different scheme than what the client is configured to use
     *
     * @return string The URL to the object
     */
    public function getObjectUrl($bucket, $key, $expires = null, array $args = array())
    {
        $command = $this->getCommand('GetObject', $args + array('Bucket' => $bucket, 'Key' => $key));

        if ($command->hasKey('Scheme')) {
            $scheme = $command['Scheme'];
            $request = $command->remove('Scheme')->prepare()->setScheme($scheme)->setPort(null);
        } else {
            $request = $command->prepare();
        }

        return $expires ? $this->createPresignedUrl($request, $expires) : $request->getUrl();
    }

    /**
     * Helper used to clear the contents of a bucket. Use the {@see ClearBucket} object directly
     * for more advanced options and control.
     *
     * @param string $bucket Name of the bucket to clear.
     *
     * @return int Returns the number of deleted keys
     */
    public function clearBucket($bucket)
    {
        $clear = new ClearBucket($this, $bucket);

        return $clear->clear();
    }

    /**
     * Determines whether or not a bucket exists by name
     *
     * @param string $bucket    The name of the bucket
     * @param bool   $accept403 Set to true if 403s are acceptable
     * @param array  $options   Additional options to add to the executed command
     *
     * @return bool
     */
    public function doesBucketExist($bucket, $accept403 = true, array $options = array())
    {
        return $this->checkExistenceWithCommand(
            $this->getCommand('HeadBucket', array_merge($options, array(
                'Bucket' => $bucket
            ))), $accept403
        );
    }

    /**
     * Determines whether or not an object exists by name
     *
     * @param string $bucket  The name of the bucket
     * @param string $key     The key of the object
     * @param array  $options Additional options to add to the executed command
     *
     * @return bool
     */
    public function doesObjectExist($bucket, $key, array $options = array())
    {
        return $this->checkExistenceWithCommand(
            $this->getCommand('HeadObject', array_merge($options, array(
                'Bucket' => $bucket,
                'Key'    => $key
            )))
        );
    }

    /**
     * Determines whether or not a bucket policy exists for a bucket
     *
     * @param string $bucket  The name of the bucket
     * @param array  $options Additional options to add to the executed command
     *
     * @return bool
     */
    public function doesBucketPolicyExist($bucket, array $options = array())
    {
        return $this->checkExistenceWithCommand(
            $this->getCommand('GetBucketPolicy', array_merge($options, array(
                'Bucket' => $bucket
            )))
        );
    }

    /**
     * Raw URL encode a key and allow for '/' characters
     *
     * @param string $key Key to encode
     *
     * @return string Returns the encoded key
     */
    public static function encodeKey($key)
    {
        return str_replace('%2F', '/', rawurlencode($key));
    }

    /**
     * Explode a prefixed key into an array of values
     *
     * @param string $key Key to explode
     *
     * @return array Returns the exploded
     */
    public static function explodeKey($key)
    {
        // Remove a leading slash if one is found
        return explode('/', $key && $key[0] == '/' ? substr($key, 1) : $key);
    }

    /**
     * Register the Amazon Scs stream wrapper and associates it with this client object
     *
     * @return self
     */
    public function registerStreamWrapper()
    {
        StreamWrapper::register($this);

        return $this;
    }

    /**
     * Upload a file, stream, or string to a bucket. If the upload size exceeds the specified threshold, the upload
     * will be performed using parallel multipart uploads.
     *
     * @param string $bucket  Bucket to upload the object
     * @param string $key     Key of the object
     * @param mixed  $body    Object data to upload. Can be a Guzzle\Http\EntityBodyInterface, stream resource, or
     *                        string of data to upload.
     * @param string $acl     ACL to apply to the object
     * @param array  $options Custom options used when executing commands:
     *     - params: Custom parameters to use with the upload. The parameters must map to a PutObject
     *       or InitiateMultipartUpload operation parameters.
     *     - min_part_size: Minimum size to allow for each uploaded part when performing a multipart upload.
     *     - concurrency: Maximum number of concurrent multipart uploads.
     *     - before_upload: Callback to invoke before each multipart upload. The callback will receive a
     *       Guzzle\Common\Event object with context.
     *
     * @see SohuCS\Scs\Model\MultipartUpload\UploadBuilder for more options and customization
     * @return \Guzzle\Service\Resource\Model Returns the modeled result of the performed operation
     */
    public function upload($bucket, $key, $body, $acl = 'private', array $options = array())
    {
        $body = EntityBody::factory($body);
        $options = Collection::fromConfig(array_change_key_case($options), array(
            'min_part_size' => AbstractMulti::MIN_PART_SIZE,
            'params'        => array(),
            'concurrency'   => $body->getWrapper() == 'plainfile' ? 3 : 1
        ));

        if ($body->getSize() < $options['min_part_size']) {
            // Perform a simple PutObject operation
            return $this->putObject(array(
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => $body,
                'ACL'    => $acl
            ) + $options['params']);
        }

        // Perform a multipart upload if the file is large enough
        $transfer = UploadBuilder::newInstance()
            ->setBucket($bucket)
            ->setKey($key)
            ->setMinPartSize($options['min_part_size'])
            ->setConcurrency($options['concurrency'])
            ->setClient($this)
            ->setSource($body)
            ->setTransferOptions($options->toArray())
            ->addOptions($options['params'])
            ->setOption('ACL', $acl)
            ->build()
            ->upload();

        if ($options['before_upload']) {
            $transfer->getEventDispatcher()->addListener(
                AbstractTransfer::BEFORE_PART_UPLOAD,
                $options['before_upload']
            );
        }

        return $transfer;
    }

    /**
     * Recursively uploads all files in a given directory to a given bucket.
     *
     * @param string $directory Full path to a directory to upload
     * @param string $bucket    Name of the bucket
     * @param string $keyPrefix Virtual directory key prefix to add to each upload
     * @param array  $options   Associative array of upload options
     *     - params: Array of parameters to use with each PutObject operation performed during the transfer
     *     - base_dir: Base directory to remove from each object key
     *     - force: Set to true to upload every file, even if the file is already in Amazon Scs and has not changed
     *     - concurrency: Maximum number of parallel uploads (defaults to 10)
     *     - debug: Set to true or an fopen resource to enable debug mode to print information about each upload
     *     - multipart_upload_size: When the size of a file exceeds this value, the file will be uploaded using a
     *       multipart upload.
     *
     * @see SohuCS\Scs\ScsSync\ScsSync for more options and customization
     */
    public function uploadDirectory($directory, $bucket, $keyPrefix = null, array $options = array())
    {
        $options = Collection::fromConfig(
            $options,
            array(
                'base_dir' => realpath($directory) ?: $directory
            )
        );

        $builder = $options['builder'] ?: UploadSyncBuilder::getInstance();
        $builder->uploadFromDirectory($directory)
            ->setClient($this)
            ->setBucket($bucket)
            ->setKeyPrefix($keyPrefix)
            ->setConcurrency($options['concurrency'] ?: 5)
            ->setBaseDir($options['base_dir'])
            ->force($options['force'])
            ->setOperationParams($options['params'] ?: array())
            ->enableDebugOutput($options['debug']);

        if ($options->hasKey('multipart_upload_size')) {
            $builder->setMultipartUploadSize($options['multipart_upload_size']);
        }

        $builder->build()->transfer();
    }

    /**
     * Downloads a bucket to the local filesystem
     *
     * @param string $directory Directory to download to
     * @param string $bucket    Bucket to download from
     * @param string $keyPrefix Only download objects that use this key prefix
     * @param array  $options   Associative array of download options
     *     - params: Array of parameters to use with each GetObject operation performed during the transfer
     *     - base_dir: Base directory to remove from each object key when storing in the local filesystem
     *     - force: Set to true to download every file, even if the file is already on the local filesystem and has not
     *       changed
     *     - concurrency: Maximum number of parallel downloads (defaults to 10)
     *     - debug: Set to true or a fopen resource to enable debug mode to print information about each download
     *     - allow_resumable: Set to true to allow previously interrupted downloads to be resumed using a Range GET
     */
    public function downloadBucket($directory, $bucket, $keyPrefix = '', array $options = array())
    {
        $options = new Collection($options);
        $builder = $options['builder'] ?: DownloadSyncBuilder::getInstance();
        $builder->setDirectory($directory)
            ->setClient($this)
            ->setBucket($bucket)
            ->setKeyPrefix($keyPrefix)
            ->setConcurrency($options['concurrency'] ?: 10)
            ->setBaseDir($options['base_dir'])
            ->force($options['force'])
            ->setOperationParams($options['params'] ?: array())
            ->enableDebugOutput($options['debug']);

        if ($options['allow_resumable']) {
            $builder->allowResumableDownloads();
        }

        $builder->build()->transfer();
    }

    /**
     * Deletes objects from Amazon Scs that match the result of a ListObjects operation. For example, this allows you
     * to do things like delete all objects that match a specific key prefix.
     *
     * @param string $bucket  Bucket that contains the object keys
     * @param string $prefix  Optionally delete only objects under this key prefix
     * @param string $regex   Delete only objects that match this regex
     * @param array  $options Options used when deleting the object:
     *     - before_delete: Callback to invoke before each delete. The callback will receive a
     *       Guzzle\Common\Event object with context.
     *
     * @see SohuCS\Scs\ScsClient::listObjects
     * @see SohuCS\Scs\Model\ClearBucket For more options or customization
     * @return int Returns the number of deleted keys
     * @throws RuntimeException if no prefix and no regex is given
     */
    public function deleteMatchingObjects($bucket, $prefix = '', $regex = '', array $options = array())
    {
        if (!$prefix && !$regex) {
            throw new RuntimeException('A prefix or regex is required, or use ScsClient::clearBucket().');
        }

        $clear = new ClearBucket($this, $bucket);
        $iterator = $this->getIterator('ListObjects', array('Bucket' => $bucket, 'Prefix' => $prefix));

        if ($regex) {
            $iterator = new FilterIterator($iterator, function ($current) use ($regex) {
                return preg_match($regex, $current['Key']);
            });
        }

        $clear->setIterator($iterator);
        if (isset($options['before_delete'])) {
            $clear->getEventDispatcher()->addListener(ClearBucket::BEFORE_CLEAR, $options['before_delete']);
        }

        return $clear->clear();
    }

    /**
     * Determines whether or not a resource exists using a command
     *
     * @param CommandInterface $command   Command used to poll for the resource
     * @param bool             $accept403 Set to true if 403s are acceptable
     *
     * @return bool
     * @throws ScsException|\Exception if there is an unhandled exception
     */
    protected function checkExistenceWithCommand(CommandInterface $command, $accept403 = false)
    {
        try {
            $command->execute();
            $exists = true;
        } catch (AccessDeniedException $e) {
            $exists = (bool) $accept403;
        } catch (ScsException $e) {
            $exists = false;
            if ($e->getResponse()->getStatusCode() >= 500) {
                // @codeCoverageIgnoreStart
                throw $e;
                // @codeCoverageIgnoreEnd
            }
        }
        return $exists;
    }
}
