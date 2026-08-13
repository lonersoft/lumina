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

use Lumina\App;
use Lumina\Permissions;
use Lumina\Hooks\Backup;
use Lumina\Chat\columns\UserColumns;
use Lumina\Chat\User\UserActivities;
use Lumina\CloudFlare\CloudFlareRealIP;
use Lumina\Middleware\PermissionMiddleware;
use Lumina\Plugins\Events\Events\BackupEvent;
use Lumina\Chat\interface\UserActivitiesTypes;

$router->get('/api/admin/backups/list', function (): void {
    App::init();
    $appInstance = App::getInstance(true);
    $appInstance->allowOnlyGET();
    global $pluginManager;
    $session = new Lumina\Chat\User\Session($appInstance);
    PermissionMiddleware::handle($appInstance, Permissions::ADMIN_BACKUPS_LIST, $session);
    $backups = Backup::getBackups();
    $appInstance->OK('Backups fetched successfully', ['backups' => $backups]);
});

$router->get('/api/admin/backup/(.*)/restore', function (string $backupId): void {
    App::init();
    $appInstance = App::getInstance(true);
    $appInstance->allowOnlyGET();
    global $pluginManager;
    $session = new Lumina\Chat\User\Session($appInstance);
    PermissionMiddleware::handle($appInstance, Permissions::ADMIN_ROOT, $session);
    UserActivities::add($session->getInfo(UserColumns::UUID, false), UserActivitiesTypes::$admin_backup_restore, CloudFlareRealIP::getRealIP(), 'Restored backup ' . $backupId);
    $backup = Backup::restoreBackup($backupId);

    if ($backup) {
        $appInstance->OK('Backup restored successfully', ['backup' => $backup]);
    } else {
        $appInstance->InternalServerError('Failed to restore backup', ['error_code' => 'BACKUP_RESTORE_FAILED']);
    }
});

$router->get('/api/admin/backup/(.*)/delete', function (string $backupId): void {
    App::init();
    $appInstance = App::getInstance(true);
    $appInstance->allowOnlyGET();
    global $pluginManager, $eventManager;
    $session = new Lumina\Chat\User\Session($appInstance);
    PermissionMiddleware::handle($appInstance, Permissions::ADMIN_BACKUPS_DELETE, $session);
    UserActivities::add($session->getInfo(UserColumns::UUID, false), UserActivitiesTypes::$admin_backup_delete, CloudFlareRealIP::getRealIP(), 'Deleted backup ' . $backupId);
    $backup = Backup::deleteBackup($backupId);
    $eventManager->emit(BackupEvent::onDeleteBackup(), ['backupId' => $backupId]);
    if ($backup) {
        $appInstance->OK('Backup deleted successfully', ['backup' => $backup]);
    } else {
        $appInstance->InternalServerError('Failed to delete backup', ['error_code' => 'BACKUP_DELETE_FAILED']);
    }
});

$router->get('/api/admin/backup/create', function (): void {
    App::init();
    $appInstance = App::getInstance(true);
    $appInstance->allowOnlyGET();
    global $pluginManager, $eventManager;
    $session = new Lumina\Chat\User\Session($appInstance);
    PermissionMiddleware::handle($appInstance, Permissions::ADMIN_BACKUPS_CREATE, $session);
    UserActivities::add($session->getInfo(UserColumns::UUID, false), UserActivitiesTypes::$admin_backup_create, CloudFlareRealIP::getRealIP(), 'Created backup');
    $eventManager->emit(BackupEvent::onCreateBackup(), []);
    $backup = Backup::takeBackup();
    $appInstance->OK('Backup created successfully', ['backup' => $backup]);
});
