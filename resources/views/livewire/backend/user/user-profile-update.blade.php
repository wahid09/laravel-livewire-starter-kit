<div>
    @section('title')
        User Profile
@endsection
<!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{--                            <div class="text-center">--}}
                            {{--                                <img class="profile-user-img img-fluid img-circle"--}}
                            {{--                                     src="{{ asset('images/logo/profile.jpg') }}"--}}
                            {{--                                     alt="User profile picture">--}}
                            {{--                            </div>--}}
                            <div class="text-center" x-data="{ imagePreview: '{{ auth()->user()->avatar_url }}' }">
                                <input wire:model="image" type="file" class="d-none" x-ref="image" x-on:change="
                                        reader = new FileReader();
                                        reader.onload = (event) => {
                                            imagePreview = event.target.result;
                                            document.getElementById('profileImage').src = `${imagePreview}`;
                                        };
                                        reader.readAsDataURL($refs.image.files[0]);
                                    "/>
                                <img x-on:click="$refs.image.click()" class="profile-user-img img-circle"
                                     x-bind:src="imagePreview ? imagePreview : '/images/logo/profile.jpg'"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->full_name }}</h3>

                            <p class="text-muted text-center">{{$user->role?->name}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Rank</b>
                                    <p class="float-right">{{$user->rank?->rank_name}}</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Unit</b>
                                    <p class="float-right">{{$user->unit?->unit_name}}</p>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b>
                                    <p class="float-right">{{$user->email}}</p>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card" x-data="{ currentTab: $persist('profile') }">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" wire:ignore>
                                <li @click.prevent="currentTab = 'profile'" class="nav-item"><a class="nav-link"
                                                                                                :class="currentTab === 'profile' ? 'active' : ''"
                                                                                                href="#profile"
                                                                                                data-toggle="tab"><i
                                            class="fa fa-user mr-1"></i> Edit Profile</a></li>
                                <li @click.prevent="currentTab = 'changePassword'" class="nav-item"><a class="nav-link"
                                                                                                       :class="currentTab === 'changePassword' ? 'active' : ''"
                                                                                                       href="#changePassword"
                                                                                                       data-toggle="tab"><i
                                            class="fa fa-key mr-1"></i> Change
                                        Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" :class="currentTab === 'profile' ? 'active' : ''" id="profile"
                                     wire:ignore.self>
                                    <form class="form-horizontal" wire:submit.prevent="updateProfile">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-sm-2 col-form-label">First Name *</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       id="first_name" placeholder="Enter your first name"
                                                       wire:model.defer="state.first_name">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       id="last_name" placeholder="Enter your last name"
                                                       wire:model.defer="state.last_name">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email Address *</label>
                                            <div class="col-sm-10">
                                                <input type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       id="email"
                                                       placeholder="Enter email" wire:model.defer="state.email">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="tel"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone"
                                                       wire:model.defer="state.phone"
                                                       pattern="[0-9]{11}">
                                                <small>Format: xxxxx-xxx-xxx</small>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                       class="form-control @error('address') is-invalid @enderror"
                                                       id="address" placeholder="Address"
                                                       wire:model.defer="state.address">
                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{--                                        <div class="form-group row">--}}
                                        {{--                                            <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>--}}
                                        {{--                                            <div class="input-group col-sm-10">--}}
                                        {{--                                                <div class="custom-file">--}}
                                        {{--                                                    <input type="file" class="custom-file-input" id="avatar"--}}
                                        {{--                                                           wire:model.defer="avatar">--}}
                                        {{--                                                    <label class="custom-file-label" for="avatar">--}}
                                        {{--                                                        @if($avatar)--}}
                                        {{--                                                            {{ $avatar->getClientOriginalName() }}--}}
                                        {{--                                                        @else--}}
                                        {{--                                                            Choose Image--}}
                                        {{--                                                        @endif--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-save mr-1"></i> Save Changes
                                                </button>
                                            </div>
                                        </div>
                                        {{--                                        <div class="form-group row">--}}
                                        {{--                                            <div class="offset-sm-3 col-sm-10">--}}
                                        {{--                                                <button type="submit" class="btn btn-danger">Submit</button>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </form>
                                </div>

                                <div class="tab-pane" :class="currentTab === 'changePassword' ? 'active' : ''"
                                     id="changePassword" wire:ignore.self>
                                    <form wire:submit.prevent="changePassword" class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="currentPassword" class="col-sm-3 col-form-label">Current
                                                Password</label>
                                            <div class="col-sm-9">
                                                <input wire:model.defer="state.current_password" type="password"
                                                       class="form-control @error('current_password') is-invalid @enderror"
                                                       id="currentPassword" placeholder="Current Password">
                                                @error('current_password')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="newPassword" class="col-sm-3 col-form-label">New
                                                Password</label>
                                            <div class="col-sm-9">
                                                <input wire:model.defer="state.password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       id="newPassword" placeholder="New Password">
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="passwordConfirmation" class="col-sm-3 col-form-label">Confirm
                                                New Password</label>
                                            <div class="col-sm-9">
                                                <input wire:model.defer="state.password_confirmation" type="password"
                                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                                       id="passwordConfirmation" placeholder="Confirm New Password">
                                                @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-save mr-1"></i> Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@push('alpine-plugins')
    <!-- Alpine Plugins -->
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function () {
            Livewire.on('nameChanged', (changedName) => {
                $('[x-ref="username"]').text(changedName);
            })
        });
    </script>
@endpush
