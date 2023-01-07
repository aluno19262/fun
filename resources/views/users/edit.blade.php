<?php
/**
 *
 * @var $user \App\Models\User
 */

view()->share('pageTitle', $user->name);
view()->share('hideSubHeader', true);

?>
<x-base-layout>
    @section('breadcrumbs')
        @can('manageApp')
            {{ Breadcrumbs::render('users.edit', $user) }}
        @else
            {{ Breadcrumbs::render('users.own_edit', $user) }}
        @endcan
    @endsection

    <div class="row gy-10 gx-xl-10">
        <!--begin::Col-->
        @if(!empty($user->associate))
            <div class="col-xl-12">
                {{ theme()->getView('home/navbar', array('associate' => $user->associate,'class' => 'card-xxl-stretch mb-5 mb-xl-10')) }}
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $user->name }}
            </h3>
        </div>
        @include('users._form')
    </div>
</x-base-layout>
