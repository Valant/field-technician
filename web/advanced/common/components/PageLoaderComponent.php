<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 26.11.14
     * Time: 06:41
     */

    namespace common\components;

    use Yii;
    use yii\base\Component;
    use yii\console\Exception;


    class PageLoaderComponent extends Component
    {
        public static function load( $url, $postParams = false, $asJSON = false, $returnHeader = true, $isPut = false )
        {
            if (filter_var( $url, FILTER_VALIDATE_URL )) {
                try {
                    $urlParts = parse_url( $url );
                    $ch       = curl_init();
                    $timeout  = 15;
                    curl_setopt( $ch, CURLOPT_URL, $url );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
                    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt(
                        $ch,
                        CURLOPT_USERAGENT,
                        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'
                    );
                    curl_setopt( $ch, CURLOPT_REFERER, "{$urlParts['scheme']}://{$urlParts['host']}/" );
                    curl_setopt( $ch, CURLOPT_ENCODING, 'UTF-8' );
                    if (isset( $postParams ) && ! empty( $postParams )) {
                        curl_setopt( $ch, CURLOPT_HTTP_VERSION, '1.1' );
                        if(!$isPut) {
                            curl_setopt( $ch, CURLOPT_POST, 1 );
                        }
                        if ($asJSON) {
                            $dataString = json_encode( $postParams );
                            if($isPut) {
                                curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
                            }else{
                                curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
                            }
                            curl_setopt( $ch, CURLOPT_POSTFIELDS, $dataString );
                            curl_setopt( $ch, CURLOPT_HEADER, $returnHeader );
                            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json',
                                'Content-Length: ' . strlen( $dataString )
                            ) );
                        } else {
                            curl_setopt( $ch, CURLOPT_POSTFIELDS, $postParams );
                        }
                    }
                    $data = curl_exec( $ch );
                    curl_close( $ch );
                    return $data;
                } catch ( Exception $e ) {
                    return false;
                }
            } else {
                throw new Exception( "No valid url: `{$url}`", 505 );
            }
        }

        public static function loadFile( $url )
        {
            if ($url) {

                $urlParts = parse_url( $url );

                $timeout  = 30;
                $tmpfname = tempnam( sys_get_temp_dir(), "img_" ) . ".png";
                $fp       = fopen( $tmpfname, "w" );
                $ch       = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_FILE, $fp );
                curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
                curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );

//                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
                curl_setopt( $ch, CURLOPT_HEADER, 0 );
                curl_setopt( $ch, CURLOPT_AUTOREFERER, false );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

                curl_setopt(
                    $ch,
                    CURLOPT_USERAGENT,
                    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'
                );

                if ( ! empty( $urlParts['scheme'] ) && ! empty( $urlParts['host'] )) {
                    curl_setopt( $ch, CURLOPT_REFERER, "{$urlParts['scheme']}://{$urlParts['host']}/" );
                }

                curl_setopt( $ch, CURLOPT_ENCODING, 'UTF-8' );


                curl_exec( $ch );
                curl_close( $ch );
                fclose( $fp );
                return $tmpfname;
            }
        }

        public static function checkRemoteFile( $url )
        {

            $ch       = curl_init( $url );
            $urlParts = parse_url( $url );
            $timeout  = 30;
            curl_setopt( $ch, CURLOPT_NOBODY, true );
            curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, false );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt(
                $ch,
                CURLOPT_USERAGENT,
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'
            );
            if ( ! empty( $urlParts['scheme'] ) && ! empty( $urlParts['host'] )) {
                curl_setopt( $ch, CURLOPT_REFERER, "{$urlParts['scheme']}://{$urlParts['host']}/" );
            }

            curl_setopt( $ch, CURLOPT_ENCODING, 'UTF-8' );

            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
            curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
            curl_exec( $ch );
            $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );


            if ($code == 200) {
                $status = true;
            } else {
                $status = false;
            }
            curl_close( $ch );
            return $status;
        }
    }