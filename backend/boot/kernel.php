<?php

/*
 * This file is part of Lumina, a fork of MythicalDash.
 *
 * MIT License
 *
 * Copyright (c) 2020-2025 MythicalSystems
 * Copyright (c) 2020-2025 Cassian Gherman (NaysKutzu)
 * Copyright (c) 2026 Lumi
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Please rather than modifying the dashboard code try to report the thing you wish on our github or write a plugin
 */

use Lumina\Plugins\PluginManager;

/*
 * This file is part of MythicalDash.
 * Please view the LICENSE file that was distributed with this source code.
 *
 * # MythicalSystems License v2.0
 *
 * ## Copyright (c) 2021–2025 MythicalSystems and Cassian Gherman
 *
 * Breaking any of the following rules will result in a permanent ban from the MythicalSystems community and all of its services.
 */

try {
    if (file_exists(APP_DIR . 'storage/packages')) {
        require APP_DIR . 'storage/packages/autoload.php';
    } else {
        throw new Exception('Packages not installed looked at this path: ' . APP_DIR . 'storage/packages');
    }
} catch (Exception $e) {
    echo $e->getMessage();
    echo "\n";
    exit;
}

if (!defined('APP_STORAGE_DIR')) {
    define('APP_STORAGE_DIR', APP_DIR . 'storage/');
}
if (!defined('APP_CACHE_DIR')) {
    define('APP_CACHE_DIR', APP_STORAGE_DIR . 'caches');
}

if (!defined('IS_CLI')) {
    ini_set('expose_php', 'off');
    header_remove('X-Powered-By');
    header_remove('Server');
}

if (!is_writable(__DIR__)) {
    $error = 'Please make sure the root directory is writable.';
    exit(json_encode(['error' => $error, 'code' => 500, 'message' => 'Please make sure the root directory is writable.', 'success' => false]));
}

if (!is_writable(__DIR__ . '/../storage')) {
    exit(json_encode(['error' => 'Please make sure the storage directory is writable.', 'code' => 500, 'message' => 'Please make sure the storage directory is writable.', 'success' => false]));
}

if (file_exists(APP_DIR . 'storage/.env')) {
    /**
     * Initialize the plugin manager.
     */
    $pluginManager = new PluginManager();
    $eventManager = $pluginManager->getEventManager();

    /**
     * @global \Lumina\Plugins\PluginManager $pluginManager
     * @global \Lumina\Plugins\Events\PluginEvent $eventManager
     */
    global $pluginManager, $eventManager;
}
