<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeStructuredFileCommand extends Command
{
    protected $signature = 'satudesa:make
                            {type : model|action|dto|enum|policy|service|livewire}
                            {name : Class name or nested path, e.g. User/CreateUser}
                            {--domain= : Domain target, e.g. User, Village, LetterRequest}
                            {--area= : Livewire area: Admin, Public, Citizen}
                            {--force : Overwrite existing file}';

    protected $description = 'Create application files following the SatuDesa DDD structure';

    public function handle(): int
    {
        $type = Str::lower((string) $this->argument('type'));
        $name = trim((string) $this->argument('name'));

        if ($name === '') {
            $this->components->error('Name is required.');

            return self::FAILURE;
        }

        return match ($type) {
            'model', 'action', 'dto', 'enum', 'policy' => $this->makeStructuredClass($type, $name),
            'service' => $this->makeRootClass('Services', $name, $type),
            'livewire' => $this->makeLivewireComponent($name),
            default => $this->invalidType($type),
        };
    }

    protected function makeStructuredClass(string $type, string $name): int
    {
        $domain = $this->option('domain');

        if (! $domain) {
            $rootMap = [
                'action' => 'Actions',
                'dto' => 'DTOs',
                'enum' => 'Enums',
                'policy' => 'Policies',
            ];

            if ($type === 'model') {
                $this->components->error('Option --domain is required for type model.');

                return self::FAILURE;
            }

            if (! isset($rootMap[$type])) {
                $this->components->error("Unsupported root type [{$type}].");

                return self::FAILURE;
            }

            return $this->makeRootClass($rootMap[$type], $name, $type);
        }

        $domain = $this->normalizeClassSegment($domain);

        $subdirectories = [
            'model' => 'Models',
            'action' => 'Actions',
            'dto' => 'DTOs',
            'enum' => 'Enums',
            'policy' => 'Policies',
        ];

        $subdirectory = $subdirectories[$type];
        $segments = $this->classSegments($name);
        $className = array_pop($segments);
        $relativeDirectory = app_path('Domains/'.$domain.'/'.$subdirectory.($segments ? '/'.implode('/', $segments) : ''));
        $relativeNamespace = 'App\\Domains\\'.$domain.'\\'.$subdirectory.($segments ? '\\'.implode('\\', $segments) : '');

        return $this->writeClassFile(
            $relativeDirectory,
            $className,
            $relativeNamespace,
            $type
        );
    }

    protected function makeRootClass(string $root, string $name, string $type): int
    {
        $segments = $this->classSegments($name);
        $className = array_pop($segments);
        $directory = app_path($root.($segments ? '/'.implode('/', $segments) : ''));
        $namespace = 'App\\'.$root.($segments ? '\\'.implode('\\', $segments) : '');

        return $this->writeClassFile($directory, $className, $namespace, $type);
    }

    protected function makeLivewireComponent(string $name): int
    {
        $areaOption = (string) ($this->option('area') ?: 'Admin');
        $area = $this->normalizeClassSegment($areaOption);

        if (! in_array($area, ['Admin', 'Public', 'Citizen'], true)) {
            $this->components->error('Option --area must be one of: Admin, Public, Citizen.');

            return self::FAILURE;
        }

        $segments = $this->classSegments($name);
        $className = array_pop($segments);
        $classDirectory = app_path('Livewire/'.$area.($segments ? '/'.implode('/', $segments) : ''));
        $classNamespace = 'App\\Livewire\\'.$area.($segments ? '\\'.implode('\\', $segments) : '');

        $classResult = $this->writeClassFile($classDirectory, $className, $classNamespace, 'livewire', false);

        if ($classResult !== self::SUCCESS) {
            return $classResult;
        }

        $viewPathSegments = array_map(
            fn (string $segment) => Str::kebab($segment),
            array_merge([$area], $segments, [$className])
        );

        $viewDirectory = resource_path('views/livewire/'.implode('/', array_slice($viewPathSegments, 0, -1)));
        $viewFile = $viewDirectory.'/'.last($viewPathSegments).'.blade.php';

        if (file_exists($viewFile) && ! $this->option('force')) {
            $this->components->warn("View already exists: {$viewFile}");
        } else {
            if (! is_dir($viewDirectory)) {
                mkdir($viewDirectory, 0755, true);
            }

            file_put_contents($viewFile, $this->livewireViewStub());
            $this->components->info('View created: '.$viewFile);
        }

        $tagName = implode('.', $viewPathSegments);
        $this->line('');
        $this->components->info("Livewire tag: <livewire:{$tagName} />");
        $this->line('View path: livewire.'.implode('.', $viewPathSegments));

        return self::SUCCESS;
    }

    protected function writeClassFile(
        string $directory,
        string $className,
        string $namespace,
        string $type,
        bool $showSuccess = true
    ): int {
        $className = $this->normalizeClassSegment($className);
        $filePath = $directory.'/'.$className.'.php';

        if (file_exists($filePath) && ! $this->option('force')) {
            $this->components->error("File already exists: {$filePath}");

            return self::FAILURE;
        }

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($filePath, $this->buildStub($namespace, $className, $type));

        if ($showSuccess) {
            $this->components->info("Created: {$filePath}");
        }

        return self::SUCCESS;
    }

    protected function buildStub(string $namespace, string $className, string $type): string
    {
        return match ($type) {
            'model' => <<<PHP
<?php

namespace {$namespace};

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$className} extends Model
{
    use HasFactory;

    protected \$guarded = [];
}
PHP,
            'action' => <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    public function handle(): void
    {
        //
    }
}
PHP,
            'dto' => <<<PHP
<?php

namespace {$namespace};

readonly class {$className}
{
    public function __construct()
    {
    }
}
PHP,
            'enum' => <<<PHP
<?php

namespace {$namespace};

enum {$className}: string
{
    case Draft = 'draft';
}
PHP,
            'policy' => <<<PHP
<?php

namespace {$namespace};

class {$className}
{
}
PHP,
            'service' => <<<PHP
<?php

namespace {$namespace};

class {$className}
{
}
PHP,
            'livewire' => $this->livewireClassStub($namespace, $className),
            default => throw new \InvalidArgumentException("Unsupported stub type [{$type}]."),
        };
    }

    protected function livewireClassStub(string $namespace, string $className): string
    {
        return <<<PHP
<?php

namespace {$namespace};

use Livewire\Component;

class {$className} extends Component
{
    public function render()
    {
        return view('livewire.{$this->livewireViewName($namespace, $className)}');
    }
}
PHP;
    }

    protected function livewireViewName(string $namespace, string $className): string
    {
        $trimmed = Str::after($namespace, 'App\\Livewire\\');
        $segments = array_filter(explode('\\', $trimmed));
        $segments[] = $className;

        return collect($segments)
            ->map(fn (string $segment) => Str::kebab($segment))
            ->implode('.');
    }

    protected function livewireViewStub(): string
    {
        return <<<'BLADE'
<div>
    <!-- Livewire component -->
</div>
BLADE;
    }

    protected function classSegments(string $name): array
    {
        $segments = preg_split('#[\\\\/]#', $name) ?: [];
        $segments = array_values(array_filter($segments, fn (?string $segment) => filled($segment)));

        return array_map(fn (string $segment) => $this->normalizeClassSegment($segment), $segments);
    }

    protected function normalizeClassSegment(string $value): string
    {
        $value = str_replace(['-', '_'], ' ', trim($value));

        return str_replace(' ', '', Str::title($value));
    }

    protected function invalidType(string $type): int
    {
        $this->components->error("Unsupported type [{$type}].");
        $this->line('Supported types: model, action, dto, enum, policy, service, livewire');

        return self::FAILURE;
    }
}
