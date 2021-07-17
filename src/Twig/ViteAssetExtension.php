<?php

namespace App\Twig;

use Psr\Cache\CacheItemPoolInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ViteAssetExtension extends AbstractExtension
{

    private ?array $manifestData = null;
    const CACHE_KEY = 'vite_manifest';
    private bool $isDev;
    private string $manifest;
    private CacheItemPoolInterface $cache;

    public function __construct(bool $isDev, string $manifest, CacheItemPoolInterface $cache)
    {
        $this->isDev = $isDev;
        $this->manifest = $manifest;
        $this->cache = $cache;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('vite_asset', [$this, 'asset'], ['is_safe' => ['html']])
        ];
    }

    public function asset(string $entry, array $deps = ['react'])
    {
        if ($this->isDev) {
            return $this->assetDev($entry, $deps);
        }
    }

    public function assetDev(string $entry, array $deps): string
    {
        $html = <<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
HTML;
        if (in_array('react', $deps)) {
            $html .= '<script type="module">
                import RefreshRuntime from "http://localhost:3000/@react-refresh"
        RefreshRuntime.injectIntoGlobalHook(window)
        window.$RefreshReg$ = () => {}
        window.$RefreshSig$ = () => (type) => type
        window.__vite_plugin_react_preamble_installed__ = true
        </script>';
        }
        $html .= <<<HTML
<script type="module" src="http://localhost:3000/assets/{$entry}" defer></script>
HTML;
        return $html;
    }
}