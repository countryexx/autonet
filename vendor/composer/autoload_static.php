<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit72181248afafc3a088e02bc1d2fde305
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'e40631d46120a9c38ea139981f8dab26' => __DIR__ . '/..' . '/ircmaxell/password-compat/lib/password.php',
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '2c102faa651ef8ea5874edb585946bce' => __DIR__ . '/..' . '/swiftmailer/swiftmailer/lib/swift_required.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '3919eeb97e98d4648304477f8ef734ba' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/Crypt/Random.php',
        'fad373d645dd668e85d44ccf3c38fbd6' => __DIR__ . '/..' . '/guzzlehttp/streams/src/functions.php',
        '04c6c5c2f7095ccf6c481d3e53e1776f' => __DIR__ . '/..' . '/mustangostang/spyc/Spyc.php',
        '154e0d165f5fe76e8e9695179d0a7345' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions.php',
        '58571171fd5812e6e447dce228f52f4d' => __DIR__ . '/..' . '/laravel/framework/src/Illuminate/Support/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tomgrohl\\Laravel\\Encryption\\' => 28,
            'TijsVerkoyen\\CssToInlineStyles\\' => 31,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Translation\\' => 30,
            'Symfony\\Component\\Security\\Core\\' => 32,
            'Symfony\\Component\\Routing\\' => 26,
            'Symfony\\Component\\Process\\' => 26,
            'Symfony\\Component\\HttpKernel\\' => 29,
            'Symfony\\Component\\HttpFoundation\\' => 33,
            'Symfony\\Component\\Finder\\' => 25,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\EventDispatcher\\' => 34,
            'Symfony\\Component\\DomCrawler\\' => 29,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Component\\CssSelector\\' => 30,
            'Symfony\\Component\\Console\\' => 26,
            'Symfony\\Component\\BrowserKit\\' => 29,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
            'Patchwork\\' => 10,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
            'Moment\\' => 7,
        ),
        'L' => 
        array (
            'LucaDegasperi\\OAuth2Server\\' => 27,
            'League\\OAuth2\\Server\\' => 21,
            'League\\Event\\' => 13,
            'League\\Csv\\' => 11,
        ),
        'I' => 
        array (
            'Intervention\\Image\\' => 19,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Stream\\' => 18,
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tomgrohl\\Laravel\\Encryption\\' => 
        array (
            0 => __DIR__ . '/..' . '/tomgrohl/laravel4-php71-encrypter/src/Tomgrohl/Laravel/Encryption',
        ),
        'TijsVerkoyen\\CssToInlineStyles\\' => 
        array (
            0 => __DIR__ . '/..' . '/tijsverkoyen/css-to-inline-styles/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Symfony\\Component\\Security\\Core\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/security-core',
        ),
        'Symfony\\Component\\Routing\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/routing',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Symfony\\Component\\HttpKernel\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/http-kernel',
        ),
        'Symfony\\Component\\HttpFoundation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/http-foundation',
        ),
        'Symfony\\Component\\Finder\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/finder',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Symfony\\Component\\DomCrawler\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dom-crawler',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Component\\CssSelector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/css-selector',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Symfony\\Component\\BrowserKit\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/browser-kit',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Patchwork\\' => 
        array (
            0 => __DIR__ . '/..' . '/patchwork/utf8/src/Patchwork',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Moment\\' => 
        array (
            0 => __DIR__ . '/..' . '/fightbulc/moment/src',
        ),
        'LucaDegasperi\\OAuth2Server\\' => 
        array (
            0 => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/src',
        ),
        'League\\OAuth2\\Server\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/oauth2-server/src',
        ),
        'League\\Event\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/event/src',
        ),
        'League\\Csv\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/csv/src',
        ),
        'Intervention\\Image\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/image/src/Intervention/Image',
        ),
        'GuzzleHttp\\Stream\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/streams/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/nesbot/carbon/src',
    );

    public static $prefixesPsr0 = array (
        'W' => 
        array (
            'Whoops' => 
            array (
                0 => __DIR__ . '/..' . '/filp/whoops/src',
            ),
        ),
        'U' => 
        array (
            'UpdateHelper\\' => 
            array (
                0 => __DIR__ . '/..' . '/kylekatarnls/update-helper/src',
            ),
        ),
        'T' => 
        array (
            'Thujohn\\Pdf' => 
            array (
                0 => __DIR__ . '/..' . '/thujohn/pdf/src',
            ),
        ),
        'S' => 
        array (
            'System' => 
            array (
                0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
            ),
            'Stack' => 
            array (
                0 => __DIR__ . '/..' . '/stack/builder/src',
            ),
            'SoapBox\\Formatter' => 
            array (
                0 => __DIR__ . '/..' . '/soapbox/laravel-formatter/src',
            ),
        ),
        'P' => 
        array (
            'Predis' => 
            array (
                0 => __DIR__ . '/..' . '/predis/predis/lib',
            ),
            'Pqb\\FilemanagerLaravel\\' => 
            array (
                0 => __DIR__ . '/..' . '/pqb/filemanager-laravel/src',
            ),
            'PHPParser' => 
            array (
                0 => __DIR__ . '/..' . '/nikic/php-parser/lib',
            ),
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
        'N' => 
        array (
            'Net' => 
            array (
                0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
            ),
        ),
        'M' => 
        array (
            'Milon\\Barcode' => 
            array (
                0 => __DIR__ . '/..' . '/milon/barcode/src',
            ),
            'Math' => 
            array (
                0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
            ),
            'Maatwebsite\\Excel\\' => 
            array (
                0 => __DIR__ . '/..' . '/maatwebsite/excel/src',
            ),
        ),
        'J' => 
        array (
            'Jeremeamia\\SuperClosure' => 
            array (
                0 => __DIR__ . '/..' . '/jeremeamia/superclosure/src',
            ),
        ),
        'I' => 
        array (
            'Illuminate' => 
            array (
                0 => __DIR__ . '/..' . '/laravel/framework/src',
            ),
        ),
        'F' => 
        array (
            'File' => 
            array (
                0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
            ),
        ),
        'C' => 
        array (
            'Crypt' => 
            array (
                0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
            ),
            'ClassPreloader' => 
            array (
                0 => __DIR__ . '/..' . '/classpreloader/classpreloader/src',
            ),
            'Cartalyst\\Sentry' => 
            array (
                0 => __DIR__ . '/..' . '/cartalyst/sentry/src',
            ),
        ),
        'B' => 
        array (
            'Boris' => 
            array (
                0 => __DIR__ . '/..' . '/d11wtq/boris/lib',
            ),
        ),
    );

    public static $classMap = array (
        'AccessTokensTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/AccessTokensTableSeeder.php',
        'Administracion' => __DIR__ . '/../..' . '/app/models/Administracion.php',
        'ApiRegistro' => __DIR__ . '/../..' . '/app/models/ApiRegistro.php',
        'Apiv1Controller' => __DIR__ . '/../..' . '/app/controllers/Apiv1Controller.php',
        'Apiv2Controller' => __DIR__ . '/../..' . '/app/controllers/Apiv2Controller.php',
        'Apiv3Controller' => __DIR__ . '/../..' . '/app/controllers/Apiv3Controller.php',
        'AuthCodesTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/AuthCodesTableSeeder.php',
        'Barrio' => __DIR__ . '/../..' . '/app/models/Barrio.php',
        'BaseController' => __DIR__ . '/../..' . '/app/controllers/BaseController.php',
        'Cartalyst\\Sentry\\Groups\\GroupExistsException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Groups/Exceptions.php',
        'Cartalyst\\Sentry\\Groups\\GroupNotFoundException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Groups/Exceptions.php',
        'Cartalyst\\Sentry\\Groups\\NameRequiredException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Groups/Exceptions.php',
        'Cartalyst\\Sentry\\Throttling\\UserBannedException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Throttling/Exceptions.php',
        'Cartalyst\\Sentry\\Throttling\\UserSuspendedException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Throttling/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\LoginRequiredException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\PasswordRequiredException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\UserAlreadyActivatedException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\UserExistsException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\UserNotActivatedException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\UserNotFoundException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Cartalyst\\Sentry\\Users\\WrongPasswordException' => __DIR__ . '/..' . '/cartalyst/sentry/src/Cartalyst/Sentry/Users/Exceptions.php',
        'Centrodecosto' => __DIR__ . '/../..' . '/app/models/Centrodecosto.php',
        'CentrodecostoController' => __DIR__ . '/../..' . '/app/controllers/CentrodecostoController.php',
        'Ciudad' => __DIR__ . '/../..' . '/app/models/Ciudad.php',
        'ClientsTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/ClientsTableSeeder.php',
        'CodeController' => __DIR__ . '/../..' . '/app/controllers/CodeController.php',
        'ComisionesController' => __DIR__ . '/../..' . '/app/controllers/ComisionesController.php',
        'Conductor' => __DIR__ . '/../..' . '/app/models/Conductor.php',
        'Conductoresexamenes' => __DIR__ . '/../..' . '/app/models/Conductoresexamenes.php',
        'Contactodirecto' => __DIR__ . '/../..' . '/app/models/Contactodirecto.php',
        'Contrato' => __DIR__ . '/../..' . '/app/models/Contrato.php',
        'Cotizacion' => __DIR__ . '/../..' . '/app/models/Cotizacion.php',
        'Cotizaciondetalle' => __DIR__ . '/../..' . '/app/models/Cotizaciondetalle.php',
        'CotizacionesController' => __DIR__ . '/../..' . '/app/controllers/CotizacionesController.php',
        'CreateOauthAccessTokenScopesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092249_create_oauth_access_token_scopes_table.php',
        'CreateOauthAccessTokensTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092248_create_oauth_access_tokens_table.php',
        'CreateOauthAuthCodeScopesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092247_create_oauth_auth_code_scopes_table.php',
        'CreateOauthAuthCodesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092246_create_oauth_auth_codes_table.php',
        'CreateOauthClientEndpointsTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092241_create_oauth_client_endpoints_table.php',
        'CreateOauthClientGrantsTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092243_create_oauth_client_grants_table.php',
        'CreateOauthClientScopesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092242_create_oauth_client_scopes_table.php',
        'CreateOauthClientsTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092240_create_oauth_clients_table.php',
        'CreateOauthGrantScopesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092239_create_oauth_grant_scopes_table.php',
        'CreateOauthGrantsTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092238_create_oauth_grants_table.php',
        'CreateOauthRefreshTokensTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092250_create_oauth_refresh_tokens_table.php',
        'CreateOauthScopesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092237_create_oauth_scopes_table.php',
        'CreateOauthSessionScopesTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092245_create_oauth_session_scopes_table.php',
        'CreateOauthSessionsTable' => __DIR__ . '/../..' . '/app/database/migrations/2016_12_01_092244_create_oauth_sessions_table.php',
        'DBTestCase' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/tests/integration/DBTestCase.php',
        'DatabaseSeeder' => __DIR__ . '/../..' . '/app/database/seeds/DatabaseSeeder.php',
        'Departamento' => __DIR__ . '/../..' . '/app/models/Departamento.php',
        'DepartamentosController' => __DIR__ . '/../..' . '/app/controllers/DepartamentosController.php',
        'EncuestasygraficasController' => __DIR__ . '/../..' . '/app/controllers/EncuestasygraficasController.php',
        'Enviofuec' => __DIR__ . '/../..' . '/app/models/Enviofuec.php',
        'Facturacion' => __DIR__ . '/../..' . '/app/models/Facturacion.php',
        'FacturacionController' => __DIR__ . '/../..' . '/app/controllers/FacturacionController.php',
        'Facturaeditada' => __DIR__ . '/../..' . '/app/models/Facturaeditada.php',
        'FilemanagerLaravelController' => __DIR__ . '/..' . '/pqb/filemanager-laravel/src/controllers/FilemanagerLaravelController.php',
        'FirmaCorreo' => __DIR__ . '/../..' . '/app/models/FirmaCorreo.php',
        'Fuec' => __DIR__ . '/../..' . '/app/models/Fuec.php',
        'FuecController' => __DIR__ . '/../..' . '/app/controllers/FuecController.php',
        'Graficoencuesta' => __DIR__ . '/../..' . '/app/models/Graficoencuesta.php',
        'GrantsTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/GrantsTableSeeder.php',
        'HistorialMails' => __DIR__ . '/../..' . '/app/models/HistorialMails.php',
        'HomeController' => __DIR__ . '/../..' . '/app/controllers/HomeController.php',
        'HvvehiculosController' => __DIR__ . '/../..' . '/app/controllers/HvvehiculosController.php',
        'IlluminateQueueClosure' => __DIR__ . '/..' . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
        'Imgvehiculo' => __DIR__ . '/../..' . '/app/models/Imgvehiculo.php',
        'Liquidacionservicios' => __DIR__ . '/../..' . '/app/models/Liquidacionservicios.php',
        'Maatwebsite\\Excel\\Classes\\Cache' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Classes/Cache.php',
        'Maatwebsite\\Excel\\Classes\\FormatIdentifier' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Classes/FormatIdentifier.php',
        'Maatwebsite\\Excel\\Classes\\LaravelExcelWorksheet' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Classes/LaravelExcelWorksheet.php',
        'Maatwebsite\\Excel\\Classes\\PHPExcel' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Classes/PHPExcel.php',
        'Maatwebsite\\Excel\\Collections\\CellCollection' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Collections/CellCollection.php',
        'Maatwebsite\\Excel\\Collections\\ExcelCollection' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Collections/ExcelCollection.php',
        'Maatwebsite\\Excel\\Collections\\RowCollection' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Collections/RowCollection.php',
        'Maatwebsite\\Excel\\Collections\\SheetCollection' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Collections/SheetCollection.php',
        'Maatwebsite\\Excel\\Excel' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Excel.php',
        'Maatwebsite\\Excel\\ExcelServiceProvider' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/ExcelServiceProvider.php',
        'Maatwebsite\\Excel\\Exceptions\\LaravelExcelException' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Exceptions/LaravelExcelException.php',
        'Maatwebsite\\Excel\\Facades\\Excel' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Facades/Excel.php',
        'Maatwebsite\\Excel\\Files\\ExcelFile' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Files/ExcelFile.php',
        'Maatwebsite\\Excel\\Files\\ExportHandler' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Files/ExportHandler.php',
        'Maatwebsite\\Excel\\Files\\File' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Files/File.php',
        'Maatwebsite\\Excel\\Files\\ImportHandler' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Files/ImportHandler.php',
        'Maatwebsite\\Excel\\Files\\NewExcelFile' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Files/NewExcelFile.php',
        'Maatwebsite\\Excel\\Filters\\ChunkReadFilter' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Filters/ChunkReadFilter.php',
        'Maatwebsite\\Excel\\Parsers\\CssParser' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Parsers/CssParser.php',
        'Maatwebsite\\Excel\\Parsers\\ExcelParser' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Parsers/ExcelParser.php',
        'Maatwebsite\\Excel\\Parsers\\ViewParser' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Parsers/ViewParser.php',
        'Maatwebsite\\Excel\\Readers\\Batch' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Readers/Batch.php',
        'Maatwebsite\\Excel\\Readers\\ConfigReader' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Readers/ConfigReader.php',
        'Maatwebsite\\Excel\\Readers\\Html' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Readers/HtmlReader.php',
        'Maatwebsite\\Excel\\Readers\\LaravelExcelReader' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Readers/LaravelExcelReader.php',
        'Maatwebsite\\Excel\\Writers\\CellWriter' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Writers/CellWriter.php',
        'Maatwebsite\\Excel\\Writers\\LaravelExcelWriter' => __DIR__ . '/..' . '/maatwebsite/excel/src/Maatwebsite/Excel/Writers/LaravelExcelWriter.php',
        'MailController' => __DIR__ . '/../..' . '/app/controllers/MailController.php',
        'Methods' => __DIR__ . '/../..' . '/app/models/Methods.php',
        'MigrationCartalystSentryInstallGroups' => __DIR__ . '/..' . '/cartalyst/sentry/src/migrations/2012_12_06_225929_migration_cartalyst_sentry_install_groups.php',
        'MigrationCartalystSentryInstallThrottle' => __DIR__ . '/..' . '/cartalyst/sentry/src/migrations/2012_12_06_225988_migration_cartalyst_sentry_install_throttle.php',
        'MigrationCartalystSentryInstallUsers' => __DIR__ . '/..' . '/cartalyst/sentry/src/migrations/2012_12_06_225921_migration_cartalyst_sentry_install_users.php',
        'MigrationCartalystSentryInstallUsersGroupsPivot' => __DIR__ . '/..' . '/cartalyst/sentry/src/migrations/2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot.php',
        'MobileController' => __DIR__ . '/../..' . '/app/controllers/MobileController.php',
        'Mtnkm' => __DIR__ . '/../..' . '/app/models/Mtnkm.php',
        'Mtnop' => __DIR__ . '/../..' . '/app/models/Mtnop.php',
        'Mtnopkm' => __DIR__ . '/../..' . '/app/models/Mtnopkm.php',
        'Mtnorevision' => __DIR__ . '/../..' . '/app/models/Mtnorevision.php',
        'NombreRuta' => __DIR__ . '/../..' . '/app/models/NombreRuta.php',
        'Normalizer' => __DIR__ . '/..' . '/patchwork/utf8/src/Normalizer.php',
        'Notification' => __DIR__ . '/../..' . '/app/models/Notification.php',
        'Novedad' => __DIR__ . '/../..' . '/app/models/Novedad.php',
        'Novedadapp' => __DIR__ . '/../..' . '/app/models/Novedadapp.php',
        'OAuthController' => __DIR__ . '/../..' . '/app/controllers/OAuthController.php',
        'Ordenfactura' => __DIR__ . '/../..' . '/app/models/Ordenfactura.php',
        'Otrosservicios' => __DIR__ . '/../..' . '/app/models/Otrosservicios.php',
        'OtrosserviciosController' => __DIR__ . '/../..' . '/app/controllers/OtrosserviciosController.php',
        'Otrosserviciosdetalle' => __DIR__ . '/../..' . '/app/models/Otrosserviciosdetalle.php',
        'Pago' => __DIR__ . '/../..' . '/app/models/Pago.php',
        'PagoServicio' => __DIR__ . '/../..' . '/app/models/Pagoservicio.php',
        'Pagocomisiones' => __DIR__ . '/../..' . '/app/models/Pagocomisiones.php',
        'Pagoproveedor' => __DIR__ . '/../..' . '/app/models/Pagoproveedor.php',
        'Pasajero' => __DIR__ . '/../..' . '/app/models/Pasajero.php',
        'PasajeroController' => __DIR__ . '/../..' . '/app/controllers/PasajeroController.php',
        'Passenger' => __DIR__ . '/../..' . '/app/models/Pasajeros.php',
        'Proveedor' => __DIR__ . '/../..' . '/app/models/Proveedor.php',
        'ProveedoresController' => __DIR__ . '/../..' . '/app/controllers/ProveedoresController.php',
        'Prueba' => __DIR__ . '/../..' . '/app/models/Prueba.php',
        'Reconfirmacion' => __DIR__ . '/../..' . '/app/models/Reconfirmacion.php',
        'RefreshTokensTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/RefreshTokensTableSeeder.php',
        'Reporteerrores' => __DIR__ . '/../..' . '/app/models/Reporteerrores.php',
        'Reportes' => __DIR__ . '/../..' . '/app/models/Reportes.php',
        'Restriccionvehiculo' => __DIR__ . '/../..' . '/app/models/Restriccionvehiculo.php',
        'Rol' => __DIR__ . '/../..' . '/app/models/Rol.php',
        'Roles' => __DIR__ . '/../..' . '/app/models/Roles.php',
        'Ruta' => __DIR__ . '/../..' . '/app/models/Ruta.php',
        'Ruta_qr' => __DIR__ . '/../..' . '/app/models/Ruta_qr.php',
        'Rutafuec' => __DIR__ . '/../..' . '/app/models/Rutafuec.php',
        'Rutaqr' => __DIR__ . '/../..' . '/app/models/Rutaqr.php',
        'Pregistro' => __DIR__ . '/../..' . '/app/models/Pregistro.php',
        'Lugar' => __DIR__ . '/../..' . '/app/models/Lugar.php',
        'RutasController' => __DIR__ . '/../..' . '/app/controllers/RutasController.php',
        'Rutat' => __DIR__ . '/../..' . '/app/models/Rutat.php',
        'ScopesTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/ScopesTableSeeder.php',
        'Seguridadsocial' => __DIR__ . '/../..' . '/app/models/Seguridadsocial.php',
        'Servicio' => __DIR__ . '/../..' . '/app/models/Servicio.php',
        'Servicioaplicacion' => __DIR__ . '/../..' . '/app/models/Servicioaplicacion.php',
        'Servicioautorizados' => __DIR__ . '/../..' . '/app/models/Servicioautorizados.php',
        'Servicioeditado' => __DIR__ . '/../..' . '/app/models/Servicioeditado.php',
        'SessionHandlerInterface' => __DIR__ . '/..' . '/symfony/http-foundation/Resources/stubs/SessionHandlerInterface.php',
        'SessionsTableSeeder' => __DIR__ . '/..' . '/lucadegasperi/oauth2-server-laravel/seeds/SessionsTableSeeder.php',
        'Soporte1Controller' => __DIR__ . '/../..' . '/app/controllers/Soporte1Controller.php',
        'Soporte2Controller' => __DIR__ . '/../..' . '/app/controllers/Soporte2Controller.php',
        'Subcentro' => __DIR__ . '/../..' . '/app/models/Subcentro.php',
        'Tarifastraslados' => __DIR__ . '/../..' . '/app/models/Tarifastraslados.php',
        'TarifastrasladosController' => __DIR__ . '/../..' . '/app/controllers/TarifastrasladosController.php',
        'TestCase' => __DIR__ . '/../..' . '/app/tests/TestCase.php',
        'TransportesController' => __DIR__ . '/../..' . '/app/controllers/TransportesController.php',
        'TransportesrutasController' => __DIR__ . '/../..' . '/app/controllers/TransportesrutasController.php',
        'TransportesrutasqrController' => __DIR__ . '/../..' . '/app/controllers/TransportesrutasqrController.php',
        'User' => __DIR__ . '/../..' . '/app/models/User.php',
        'UsuariosController' => __DIR__ . '/../..' . '/app/controllers/UsuariosController.php',
        'Vehiculo' => __DIR__ . '/../..' . '/app/models/Vehiculo.php',
        'VehiculoConductorPivot' => __DIR__ . '/../..' . '/app/models/VehiculoConductorPivot.php',
        'Whoops\\Module' => __DIR__ . '/..' . '/filp/whoops/src/deprecated/Zend/Module.php',
        'Whoops\\Provider\\Zend\\ExceptionStrategy' => __DIR__ . '/..' . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
        'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => __DIR__ . '/..' . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
        'hvcomparendos' => __DIR__ . '/../..' . '/app/models/hvcomparendos.php',
        'hvconductores' => __DIR__ . '/../..' . '/app/models/hvconductores.php',
        'hvdocumentacion' => __DIR__ . '/../..' . '/app/models/hvdocumentacion.php',
        'hvmantenimientos' => __DIR__ . '/../..' . '/app/models/hvmantenimientos.php',
        'hvsuceso' => __DIR__ . '/../..' . '/app/models/hvsuceso.php',
        'hvvehiculo' => __DIR__ . '/../..' . '/app/models/hvvehiculo.php',
        'importController' => __DIR__ . '/../..' . '/app/controllers/importController.php',
        'listadoController' => __DIR__ . '/../..' . '/app/controllers/listadoController.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit72181248afafc3a088e02bc1d2fde305::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit72181248afafc3a088e02bc1d2fde305::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit72181248afafc3a088e02bc1d2fde305::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit72181248afafc3a088e02bc1d2fde305::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit72181248afafc3a088e02bc1d2fde305::$classMap;

        }, null, ClassLoader::class);
    }
}
