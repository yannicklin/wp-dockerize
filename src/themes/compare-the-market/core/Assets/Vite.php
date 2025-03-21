<?php

namespace Atlas\Core\Assets;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Vite
{
    /**
     * @var array
     */
    protected $scripts = [];

    /**
     * @var array
     */
    protected $styles = [];

    /**
     * @var bool
     */
    protected $hot = false;

    public function getScripts()
    {
        return $this->scripts;
    }

    public function getStyles()
    {
        return $this->styles;
    }

    public function isHot()
    {
        return $this->hot;
    }

    /**
     * Generate Vite tags for an entrypoint.
     *
     * @param  string|string[]  $entrypoints
     * @param  string  $buildDirectory
     * @return array
     *
     * @throws \Exception
     */
    public function __invoke($entrypoints, $buildDirectory = 'build')
    {
        static $manifests = [];

        $entrypoints = collect($entrypoints);
        $buildDirectory = Str::start($buildDirectory, '/');

        // a hot file gets put into the public dir so that we can detect if dev is being run
        if (is_file(public_path('/hot'))) {
            $this->hot = true;

            $url = rtrim(file_get_contents(public_path('/hot')));

            $this->scripts[] = $url . '/' . '@vite/client';

            foreach ($entrypoints as $entrypoint) {
                if ($this->isCssPath($entrypoint)) {
                    $this->styles[$entrypoint] = $url . '/' . $entrypoint;
                } else {
                    $this->scripts[$entrypoint] = $url . '/' . $entrypoint;
                }
            }


            return [$this->getStyles(), $this->getScripts(), $this->isHot()];
        }

        $manifestPath = public_path($buildDirectory . '/manifest.json');

        if (! isset($manifests[$manifestPath])) {
            if (! is_file($manifestPath)) {
                throw new Exception("Vite manifest not found at: {$manifestPath}");
            }

            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];

        foreach ($entrypoints as $entrypoint) {
            if (! isset($manifest[$entrypoint])) {
                throw new Exception("Unable to locate file in Vite manifest: {$entrypoint}.");
            }

            if ($this->isCssPath($entrypoint)) {
                $this->styles[$entrypoint] = theme_asset("{$buildDirectory}/{$manifest[$entrypoint]['file']}");
            } else {
                $this->scripts[$entrypoint] = theme_asset("{$buildDirectory}/{$manifest[$entrypoint]['file']}");
            }
        }

        return [$this->getStyles(), $this->getScripts(), $this->isHot()];
    }

    /**
     * Determine whether the given path is a CSS file.
     *
     * @param  string  $path
     * @return bool
     */
    protected function isCssPath($path)
    {
        return preg_match('/\.(css|less|sass|scss|styl|stylus|pcss|postcss)$/', $path) === 1;
    }
}
