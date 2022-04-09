<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class OrchidLayoutMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'layout';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-orchid-layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Orchid layout for the specified module.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!$this->isLayoutTypeValid()) {
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
            ['layout', InputArgument::REQUIRED, 'The name of layout will be created.'],
            ['type', InputArgument::REQUIRED, 'The type of layout will be created.'],
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
            'SCREEN_NAME'             => $this->getLayoutName(),
            'CLASS_NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'                   => $this->getLayoutName(),
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

        $layoutPath = GenerateConfigReader::read('orchid-layout');

        return $path . $layoutPath->getPath() . '/' . $this->getLayoutName() . '.php';
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.orchid-layout.namespace') ?: $module->config('paths.generator.orchid-layout.path');
    }

    /**
     * @return mixed|string
     */
    private function getLayoutName()
    {
        $layoutName = Str::studly($this->argument('layout'));
        $layoutType = $this->getLayoutType();

        if ($layoutType === 'list') {
            $layoutName = $this->safeAppend($layoutName, 'ListLayout');
        } else if ($layoutType === 'edit') {
            $layoutName = $this->safeAppend($layoutName, 'EditLayout');
        }

        return $layoutName;
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

    private function isLayoutTypeValid(): bool
    {
        $layoutType = $this->getLayoutType();

        if (in_array($layoutType, ['list', 'edit'])) {
            return true;
        }

        $this->error("Unsupport layout type : {$layoutType}");

        return false;
    }

    private function getLayoutType(): string
    {
        return strtolower($this->argument('type'));
    }

    private function getStubName(): string
    {
        return '/orchid-' .  $this->getLayoutType() . '-layout.stub';
    }

    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly($this->argument('model'));
    }
}
