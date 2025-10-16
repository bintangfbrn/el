<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\RouteBreadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('akun.permission.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Permission', route('akun.permission.index'));
});

Breadcrumbs::for('akun.role.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('akun.role.index'));
});

Breadcrumbs::for('akun.role.create', function ($trail) {
    $trail->parent('akun.role.index');
    $trail->push('Tambah Data', route('akun.role.create'));
});
Breadcrumbs::for('akun.role.edit', function ($trail) {
    $trail->parent('akun.role.index');
    $trail->push('Ubah Data', route('akun.role.edit', 1));
});
Breadcrumbs::for('akun.user.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('akun.user.index'));
});
Breadcrumbs::for('akun.user.create', function ($trail) {
    $trail->parent('akun.user.index');
    $trail->push('Tambah Data', route('akun.user.create'));
});
Breadcrumbs::for('designer.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Designer', route('designer.index'));
});
Breadcrumbs::for('service.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Service', route('service.index'));
});

Breadcrumbs::for('services-items', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Service Items', route('services-items'));
});

Breadcrumbs::for('create-services-items', function ($trail) {
    $trail->parent('services-items');
    $trail->push('Create Service Items', route('create-services-items'));
});

Breadcrumbs::for('edit-services-items', function ($trail, $id) {
    $trail->parent('services-items');
    $trail->push('Edit Service Items', route('edit-services-items', $id));
});
