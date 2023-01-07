<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('Home'), route('home'), ['isHome' => true]);
});

// Home > User
Breadcrumbs::for('users.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Users'), route('users.index'));
});
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users.index');
    $trail->push(__('Create'), route('users.create'));
});
Breadcrumbs::for('users.show', function ($trail, $user) {
    $trail->parent('users.index');
    $trail->push($user->name, route('users.show', $user));
});
Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('users.show', $user);
    $trail->push(__('Update'), route('users.edit', $user));
});
Breadcrumbs::for('users.own_show', function ($trail, $user) {
    $trail->parent('home');
    $trail->push($user->name, route('users.show', $user));
});
Breadcrumbs::for('users.own_edit', function ($trail, $user) {
    $trail->parent('users.own_show', $user);
    $trail->push(__('Update'), route('users.edit', $user));
});

// Home > Role
Breadcrumbs::for('roles.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Roles'), route('roles.index'));
});
Breadcrumbs::for('roles.create', function ($trail) {
    $trail->parent('roles.index');
    $trail->push(__('Create'), route('roles.create'));
});
Breadcrumbs::for('roles.show', function ($trail, $model) {
    $trail->parent('roles.index');
    $trail->push($model->name, route('roles.show', $model));
});
Breadcrumbs::for('roles.edit', function ($trail, $model) {
    $trail->parent('roles.show', $model);
    $trail->push(__('Update'), route('roles.edit', $model));
});

// Home > Settings
Breadcrumbs::for('settings.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Settings'), route('settings.index'));
});
Breadcrumbs::for('settings.create', function ($trail) {
    $trail->parent('settings.index');
    $trail->push(__('Create'), route('settings.create'));
});
Breadcrumbs::for('settings.show', function ($trail, $model) {
    $trail->parent('settings.index');
    $trail->push($model->name, route('settings.show', $model));
});
Breadcrumbs::for('settings.edit', function ($trail, $model) {
    $trail->parent('settings.show', $model);
    $trail->push(__('Update'), route('settings.edit', $model));
});

// Home > Permissions
Breadcrumbs::for('permissions.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Permissions'), route('permissions.index'));
});
Breadcrumbs::for('permissions.create', function ($trail) {
    $trail->parent('permissions.index');
    $trail->push(__('Create'), route('permissions.create'));
});
Breadcrumbs::for('permissions.show', function ($trail, $model) {
    $trail->parent('permissions.index');
    $trail->push($model->name, route('permissions.show', $model));
});
Breadcrumbs::for('permissions.edit', function ($trail, $model) {
    $trail->parent('permissions.show', $model);
    $trail->push(__('Update'), route('permissions.edit', $model));
});

// Home > Demo
Breadcrumbs::for('demos.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Demos'), route('demos.index'));
});
Breadcrumbs::for('demos.create', function ($trail) {
    $trail->parent('demos.index');
    $trail->push(__('Create'), route('demos.create'));
});
Breadcrumbs::for('demos.show', function ($trail, $model) {
    $trail->parent('demos.index');
    $trail->push($model->name, route('demos.show', $model));
});
Breadcrumbs::for('demos.edit', function ($trail, $model) {
    $trail->parent('demos.show', $model);
    $trail->push(__('Update'), route('demos.edit', $model));
});

// Home > Associates
Breadcrumbs::for('associates.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Associates'), route('associates.index'));
});
// Home > Associates
Breadcrumbs::for('associates.in_evaluation_index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Associates'), route('associates.in_evaluation_index'));
});
Breadcrumbs::for('associates.create', function ($trail) {
    $trail->parent('associates.index');
    $trail->push(__('Create'), route('associates.create'));
});
Breadcrumbs::for('associates.show', function ($trail, $model) {
    $trail->parent('associates.index');
    $trail->push($model->name, route('associates.show', $model));
});
Breadcrumbs::for('associates.edit', function ($trail, $model) {

    $trail->parent('associates.show', $model);
    $trail->push(__('Update'), route('associates.edit', $model));
});
Breadcrumbs::for('associates.evaluations', function ($trail, $model) {
    $trail->parent('home', $model);
    $trail->push(__('Evaluations'), route('associates.evaluations', $model));
});

// Home > Orders
Breadcrumbs::for('orders.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Orders'), route('orders.index'));
});
Breadcrumbs::for('orders.create', function ($trail) {
    $trail->parent('orders.index');
    $trail->push(__('Create'), route('orders.create'));
});
Breadcrumbs::for('orders.show', function ($trail, $model) {
    $trail->parent('orders.index');
    if(!empty($model->associate_id)){
        $trail->push($model->associate->name,route('associates.show', $model->associate));
    }
    $trail->push($model->id,route('orders.show', $model));
});
Breadcrumbs::for('orders.edit', function ($trail, $model) {
    $trail->parent('orders.index');
    if(!empty($model->associate_id)){
        $trail->push($model->associate->name,route('associates.show', $model->associate));
    }
    $trail->push(__('Update'), route('orders.edit', $model));
});

// Home > Declarations
Breadcrumbs::for('declarations.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Declarations'), route('declarations.index'));
});
// Home > Declarations
Breadcrumbs::for('declarations.waiting_approval', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Declarations Waiting Approval'), route('declarations.waiting_approval'));
});
Breadcrumbs::for('declarations.create', function ($trail) {
    $trail->parent('declarations.index');
    $trail->push(__('Create'), route('declarations.create'));
});
Breadcrumbs::for('declarations.show', function ($trail, $model) {
    $trail->parent('declarations.index');
    $trail->push($model->id, route('declarations.show', $model));
});
Breadcrumbs::for('declarations.edit', function ($trail, $model) {
    $trail->parent('declarations.show', $model);
    $trail->push(__('Update'), route('declarations.edit', $model));
});

// Home > Companies
Breadcrumbs::for('companies.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Companies'), route('companies.index'));
});
Breadcrumbs::for('companies.create', function ($trail) {
    $trail->parent('companies.index');
    $trail->push(__('Create'), route('companies.create'));
});
Breadcrumbs::for('companies.show', function ($trail, $model) {
    $trail->parent('companies.index');
    $trail->push($model->name, route('companies.show', $model));
});
Breadcrumbs::for('companies.edit', function ($trail, $model) {
    $trail->parent('companies.show', $model);
    $trail->push(__('Update'), route('companies.edit', $model));
});

// Home > Find Aps
Breadcrumbs::for('find-aps.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Find Aps'), route('find-aps.index'));
});
Breadcrumbs::for('find-aps.create', function ($trail) {
    $trail->parent('find-aps.index');
    $trail->push(__('Create'), route('find-aps.create'));
});
Breadcrumbs::for('find-aps.show', function ($trail, $model) {
    $trail->parent('find-aps.index');
    $trail->push($model->name, route('find-aps.show', $model));
});
Breadcrumbs::for('find-aps.edit', function ($trail, $model) {
    $trail->parent('find-aps.show', $model);
    $trail->push(__('Update'), route('find-aps.edit', $model));
});

// Home > Declaration Templates
Breadcrumbs::for('declaration_templates.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Declaration Templates'), route('declaration_templates.index'));
});
Breadcrumbs::for('declaration_templates.create', function ($trail) {
    $trail->parent('declaration_templates.index');
    $trail->push(__('Create'), route('declaration_templates.create'));
});
Breadcrumbs::for('declaration_templates.show', function ($trail, $model) {
    $trail->parent('declaration_templates.index');
    $trail->push($model->name, route('declaration_templates.show', $model));
});
Breadcrumbs::for('declaration_templates.edit', function ($trail, $model) {
    $trail->parent('declaration_templates.show', $model);
    $trail->push(__('Update'), route('declaration_templates.edit', $model));
});

// Home > Contacts
Breadcrumbs::for('contacts.index', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Contacts'), route('contacts.index'));
});
Breadcrumbs::for('contacts.create', function ($trail) {
    $trail->parent('contacts.index');
    $trail->push(__('Create'), route('contacts.create'));
});
Breadcrumbs::for('contacts.show', function ($trail, $model) {
    $trail->parent('roles.index');
    $trail->push($model->name, route('contacts.show', $model));
});
Breadcrumbs::for('contacts.edit', function ($trail, $model) {
    $trail->parent('contacts.show', $model);
    $trail->push(__('Update'), route('contacts.edit', $model));
});

/*
// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});*/
