<?php

namespace Adtech\Application\Cms\Package\Console\Commands\Creators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Doctrine\Common\Inflector\Inflector;

/**
 * Class PackageCreator
 *
 * @package Adtech\Application\Cms\Package\Console\Commands\Creators
 */
class PackageCreator
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var
     */
    protected $vendor;

    /**
     * @var
     */
    protected $package;

    /**
     * @var
     */
    protected $options = array();

    /**
     * @var
     */
    protected $model;

    /**
     * @var string
     */
    protected $srcDirectory = 'src';

    protected $createDirectories = array(
        'app' => 'app',
        'app/http' => 'app/Http',
        'controller' => 'app/Http/Controllers',
        'model' => 'app/Models',
        'database' => 'database/migrations',
        'seed' => 'database/seeds',
        'repository' => 'app/Repositories',
        'routes' => 'routes',
        'views' => 'views/$GROUP_NAME$/$SKIN$/views/modules/$PACKAGE$/demo',
        'public' => 'views/$GROUP_NAME$/$SKIN$/public',
        'locale' => 'translations',
        'locale/language' => 'translations/$LOCALE$',
    );

    protected $createFiles = array(
        'composer.stub' => 'composer.json',
        'modules.stub' => 'modules.json',
        'routes.stub' => 'routes/web.php',
        'service.provider.stub' => '$PACKAGE_LAST_NAME$ServiceProvider.php',
        'controller.stub' => 'app/Http/Controllers/$CONTROLLER_NAME$Controller.php',
        'model.stub' => 'app/Models/$MODEL_NAME$.php',
        'repository.stub' => 'app/Repositories/$REPOSITORY_NAME$Repository.php',
        'translation.stub' => 'translations/$LOCALE$/language.php',
        'view.manage.stub' => 'views/$GROUP_NAME$/$SKIN$/views/modules/$PACKAGE$/demo/manage.blade.php',
        'view.create.stub' => 'views/$GROUP_NAME$/$SKIN$/views/modules/$PACKAGE$/demo/create.blade.php',
        'view.edit.stub' => 'views/$GROUP_NAME$/$SKIN$/views/modules/$PACKAGE$/demo/edit.blade.php',
    );

    protected $createFileOption = array(
        'controller' => array(
            'controller.stub' => '$CONTROLLER_NAME$Controller.php'
        ),
        'model' => array(
            'model.stub' => '$MODEL_NAME$.php'
        ),
        'repository' => array(
            'repository.stub' => '$REPOSITORY_NAME$Repository.php'
        ),
        'locale/language' => array(
            'translation.stub' => '$LOCALE$.php',
        ),
        'views' => array(
            'view.manage.stub' => 'manage.blade.php',
            'view.create.stub' => 'create.blade.php',
            'view.edit.stub' => 'edit.blade.php'
        )
    );

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options = array())
    {
        $this->options = $options;
    }

    /**
     * Create the package.
     *
     * @param $vendor
     * @param $package
     * @param $model
     * @return int
     */
    public function create($vendor, $package, $options = array())
    {
        // Set the vendor.
        $this->setVendor($vendor);

        // Set the package
        $this->setPackage($package);

        // Set the model.
        $this->setOptions($options);

        // Create the directory.
        $this->createDirectory();

        /** get model option **/
        $model = isset($options['model']) ? $options['model'] : null;
        /** get model option **/
        $controller = isset($options['controller']) ? $options['controller'] : null;
        /** get criteria option **/
        $criteria = isset($options['criteria']) ? $options['criteria'] : null;
        /** get repository option **/
        $repository = isset($options['repository']) ? $options['repository'] : null;
        /** get translation option **/
        $locale = isset($options['locale']) ? $options['locale'] : null;

        $sections = array(
            'model' => $model,
            'controller' => $controller,
            'criteria' => $criteria,
            'repository' => $repository,
            'locale/language' => $locale,
        );
        $sectionCreate = false;
        foreach ($sections as $k => $section) {
            $sectionCreate = ($section != null) ? true : $sectionCreate;
            $replaceOptions = [];
            $replaceOptions['$LOCALE$'] = config('app.locale');
            $replaceOptions['$PACKAGE$'] = $this->package;
            switch ($k) {
                case 'locale':
                case 'locale/language':
                    $replaceOptions['$LOCALE$'] = $section;
                    break;
                case 'controller':
                    $replaceOptions['$CONTROLLER_NAME$'] = str_replace('Controller', '', $section);
                    $replaceOptions['controller_namespace'] = str_replace('Controller', '', $section);
                    break;
                case 'model':
                    $replaceOptions['$MODEL_NAME$'] = $section;
                    $replaceOptions['model_namespace'] = $section;
                    break;
                case 'repository':
                    $replaceOptions['$REPOSITORY_NAME$'] = str_replace('Repository', '', $section);
                    $replaceOptions['repository_namespace'] = str_replace('Repository', '', $section);
                    break;
            }
            $sectionCreate && $this->createFile($k, $replaceOptions);
        }

        if ($sectionCreate == false) {
            // Create the files.
            $replaceOptions['$MODEL_NAME$'] = 'Demo';
            $replaceOptions['$CONTROLLER_NAME$'] = 'Demo';
            $replaceOptions['controller_namespace'] = 'Demo';
            $replaceOptions['controller_name'] = 'demo';

            $replaceOptions['$REPOSITORY_NAME$'] = 'Demo';
            $replaceOptions['repository_namespace'] = 'Demo';
            $replaceOptions['model_path'] = ucfirst($this->vendor) . '\\' . ucfirst($this->package) . '\App\Models';
            $replaceOptions['model_name'] = 'Demo';

            $replaceOptions['$LOCALE$'] = config('app.locale');

            $this->createFile(null, $replaceOptions);
        }

        return true;
    }

    protected function createDirectory()
    {
        //Get theme setup
        $groupName = config('site.group_name');
        $groupName = $groupName ? $groupName : 'default';
        $skin = config('site.desktop.skin');
        $skin = $skin ? $skin : 'default';

        // Directory.
        $directory = $this->getDirectory();

        // Check if the directory exists.
        if (!$this->files->isDirectory($directory)) {
            // Create the directory if not.
            $this->files->makeDirectory($directory, 0755, true);
        }

        $srcDirectory = $directory . DIRECTORY_SEPARATOR . $this->srcDirectory;
        // Check if the directory exists.
        if (!$this->files->isDirectory($srcDirectory)) {
            // Create the directory if not.
            $this->files->makeDirectory($srcDirectory, 0755, true);
        }

        if ($this->createDirectories) {
            foreach ($this->createDirectories as $k => $createDirectory) {
                $createDirectory = str_replace('$LOCALE$', config('app.locale'), $createDirectory);
                $createDirectory = str_replace('$PACKAGE$', $this->package, $createDirectory);
                $createDirectory = str_replace('$GROUP_NAME$', $groupName, $createDirectory);
                $createDirectory = str_replace('$SKIN$', $skin, $createDirectory);
                $createDirectory = $srcDirectory . DIRECTORY_SEPARATOR . $createDirectory;
                if (!$this->files->isDirectory($createDirectory)) {
                    // Create the directory if not.
                    $this->files->makeDirectory($createDirectory, 0755, true);
                }
            }
        }
    }

    protected function createFile($section = null, $replaceOptions = array())
    {
        //Get theme setup
        $groupName = config('site.group_name');
        $groupName = $groupName ? $groupName : 'default';
        $skin = config('site.desktop.skin');
        $skin = $skin ? $skin : 'default';

        // Directory.
        $directory = $this->getDirectory();
        $srcDirectory = $directory . DIRECTORY_SEPARATOR . $this->srcDirectory;

        $packageName = $this->getPackage();
        $packageData = explode('-', $packageName);

        $replaces = array(
            '$PACKAGE_LAST_NAME$' => ucfirst($packageData[count($packageData) - 1]),
            '$GROUP_NAME$' => $groupName,
            '$SKIN$' => $skin
        );

        if ($replaceOptions) {
            foreach ($replaceOptions as $k => $v) {
                $replaces[$k] = $v;
            }
        }

        $createFiles = [];
        if ($section != null && isset($this->createFileOption[$section])) {
            $createFiles = $this->createFileOption[$section];
        } else {
            $createFiles = $this->createFiles;
        }

        if ($createFiles) {
            // Populate data
            $populateData = $this->getPopulateData($replaces);
            foreach ($createFiles as $stub => $file) {

                $stub = ($this->options['backend'] == 1 && $stub == 'routes.stub') ? 'routes_backend.stub' : $stub;
                $stubFile = $this->getStubPath() . '/' . $stub;
                foreach ($replaces as $k => $v) {
                    $file = str_replace($k, $v, $file);
                }

                $this->createDirectories['locale/language'] = str_replace('$LOCALE$', config('app.locale'), $this->createDirectories['locale/language']);
                $this->createDirectories['views'] = str_replace('$GROUP_NAME$', $groupName, $this->createDirectories['views']);
                $this->createDirectories['views'] = str_replace('$SKIN$', $skin, $this->createDirectories['views']);


                if ($section && isset($this->createDirectories[$section])) {
                    $file = $srcDirectory . DIRECTORY_SEPARATOR . $this->createDirectories[$section]
                        . DIRECTORY_SEPARATOR . $file;
                } elseif ($file == 'composer.json' || $file == 'modules.json') {
                    $file = $directory . DIRECTORY_SEPARATOR . $file;
                } else {
                    $file = $srcDirectory . DIRECTORY_SEPARATOR . $file;
                }
                // Stub
                $stub = $this->files->get($stubFile);
                // Loop through the populate data.
                foreach ($populateData as $key => $value) {
                    // Populate the stub.
                    $stub = str_replace($key, $value, $stub);
                }
                $this->files->put($file, $stub);
            }
        }
    }

    /**
     * Get the repository directory.
     *
     * @return mixed
     */
    protected function getDirectory()
    {
        // Get the directory from the config file.
        $directory = Config::get('packages.package_path');
        $vendor = $this->getVendor();
        $packageName = $this->getPackage();
        $directory = ($this->options['path_value'] == -1) ? '../'.$directory : $directory;
        $directory = $directory . DIRECTORY_SEPARATOR . $vendor . DIRECTORY_SEPARATOR . $packageName;

        // Return the directory.
        return $directory;
    }

    /**
     * @return string
     */
    protected function getPackageService()
    {
        $packageName = $this->getPackage();
        $packageData = explode('-', $packageName);
        return $packageServiceFile = ucfirst($packageData[count($packageData) - 1]) . 'ServiceProvider';
    }

    /**
     * Get the populate data.
     *
     * @return array
     */
    protected function getPopulateData($replaces = [])
    {
        // Repository namespace.
        $packageName = $this->getPackage();
        $packageDirectory = strtolower($packageName);
        $packageData = explode('-', $packageName);
        $packageNamespace = null;
        $packageClass = null;
        foreach ($packageData as $k => $v) {
            $packageNamespace .= ucfirst($v);
            if ($k == count($packageData) - 1) {
                $packageClass = ucfirst($v);
            }
        }

        $vendorName = strtolower($this->getVendor());
        $vendorNamespace = ucfirst($this->getVendor());

        // Populate data.
        $populateData = [
            'vendor_namespace' => $vendorNamespace,
            'vendor_nameup' => strtoupper($vendorName),
            'vendor_name' => $vendorName,
            'package_namespace' => $packageNamespace,
            'package_nameup' => strtoupper($packageDirectory),
            'package_class' => $packageClass,
            'package_name' => $packageDirectory,
            'package_directory' => $packageDirectory,
        ];

        if ($replaces) {
            foreach ($replaces as $k => $v) {
                $populateData[$k] = $v;
            }
        }

        // Return populate data.
        return $populateData;
    }

    /**
     * Get the stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        // Stub path.
        $stub_path = __DIR__ . '/../../../../../resources/stubs/';

        // Return the stub path.
        return $stub_path;
    }
}
