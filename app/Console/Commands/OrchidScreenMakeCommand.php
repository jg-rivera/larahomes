<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class OrchidScreenMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'screen';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-orchid-screen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Orchid screen for the specified module.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!$this->isScreenTypeValid()) {
            return E_ERROR;
        }

        if (parent::handle() === E_ERROR) {
            return E_ERROR;
        }

        return 0;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['screen', InputArgument::REQUIRED, 'The name of screen will be created.'],
            ['type', InputArgument::REQUIRED, 'The type of screen will be created.'],
            ['model', InputArgument::REQUIRED, 'The name of model will be used.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODEL_NAME'              => $this->getModelName(),
            'MODEL_PLURAL_NAME'       => Str::plural($this->getModelName()),
            'MODEL_PLURAL_LOWER_NAME' => Str::plural(strtolower($this->getModelName())),
            'MODEL_LOWER_NAME'        => strtolower($this->getModelName()),
            'SCREEN_NAME'             => $this->getScreenName(),
            'CLASS_NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'                   => $this->getScreenName(),
            'MODULE_LOWER_NAME'       => $module->getLowerName(),
            'MODULE_NAME'             => $this->getModuleName(),
            'MODULE_STUDLY_NAME'      => $module->getStudlyName(),
            'MODULE_NAMESPACE'        => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $screenPath = GenerateConfigReader::read('orchid-screen');

        return $path . $screenPath->getPath() . '/' . $this->getScreenName() . '.php';
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.orchid-screen.namespace') ?: $module->config('paths.generator.orchid-screen.path');
    }

    /**
     * @return mixed|string
     */
    private function getScreenName()
    {
        $screenName = Str::studly($this->argument('screen'));
        $screenType = $this->getScreenType();

        if ($screenType === 'list') {
            $screenName = $this->safeAppend($screenName, 'ListScreen');
        } else if ($screenType === 'edit') {
            $screenName = $this->safeAppend($screenName, 'EditScreen');
        }

        return $screenName;
    }

    /**
     * @return mixed|string
     */
    private function safeAppend($subject, $toAppend)
    {
        if (Str::contains(strtolower($subject), strtolower($toAppend))) {
            return;
        }

        return $subject . $toAppend;
    }

    private function isScreenTypeValid(): bool
    {
        $screenType = $this->getScreenType();

        if (in_array($screenType, ['list', 'edit'])) {
            return true;
        }

        $this->error("Unsupport screen type : {$screenType}");

        return false;
    }

    private function getScreenType(): string
    {
        return strtolower($this->argument('type'));
    }

    private function getStubName(): string
    {
        return '/orchid-' .  $this->getScreenType() . '-screen.stub';
    }

    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly($this->argument('model'));
    }
}
