@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')
<div class="container py-section" style="max-width:860px;">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span>
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span>
        <span>Profile</span>
    </div>

    <div class="section-header"><h1 class="section-title">👤 Edit Profile</h1></div>

    <div style="display:grid;grid-template-columns:200px 1fr;gap:2rem;align-items:start;">

        {{-- Avatar sidebar --}}
        <div style="text-align:center;">
            <x-image-or-icon :path="$user->avatar" icon="fa-user" size="140px" rounded alt="Avatar" id="avatar-preview" style="border:3px solid var(--border);margin-bottom:1rem;" />
            <div style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:0.5rem;">Click below to change avatar</div>
            <label class="btn btn-secondary btn-sm" style="cursor:pointer;display:inline-block;">
                <i class="fa-solid fa-camera" aria-hidden="true"></i> Upload Photo
                <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
            </label>
        </div>

        {{-- Profile form --}}
        <div>
            {{-- Main profile --}}
            <div class="card" style="padding:2rem;margin-bottom:1.5rem;">
                <h2 style="font-size:1rem;font-weight:700;margin-bottom:1.5rem;">Profile Information</h2>

                @if(session('success'))
                <div class="alert alert-success" data-auto-dismiss="4000">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                <div class="alert alert-error"><ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    {{-- Hidden avatar field --}}
                    <input type="file" name="avatar" id="avatar-form-input" style="display:none;" accept="image/*">

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label class="form-label">Display Name *</label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bio <span style="color:var(--text-secondary);font-weight:400;">(max 500 chars)</span></label>
                        <textarea name="bio" class="form-textarea" rows="3" maxlength="500" placeholder="Tell us about yourself…">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Favourite Fandoms</label>
                        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                            @foreach($categories as $cat)
                            <label style="cursor:pointer;">
                                <input type="checkbox" name="favorite_fandoms[]" value="{{ $cat->name }}"
                                    {{ in_array($cat->name, $user->favorite_fandoms ?? []) ? 'checked' : '' }}
                                    style="display:none;" class="fandom-checkbox" id="fav-{{ $cat->slug }}">
                                <span class="category-chip" id="chip-fav-{{ $cat->slug }}" onclick="toggleChip('fav-{{ $cat->slug }}','chip-fav-{{ $cat->slug }}')"
                                    style="{{ in_array($cat->name, $user->favorite_fandoms ?? []) ? 'border-color:var(--purple);background:rgba(74,38,183,0.15);color:var(--text-main);' : '' }}">
                                    {{ $cat->icon }} {{ $cat->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categories of Interest</label>
                        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                            @foreach($categories as $cat)
                            <label style="cursor:pointer;">
                                <input type="checkbox" name="categories_of_interest[]" value="{{ $cat->slug }}"
                                    {{ in_array($cat->slug, $user->categories_of_interest ?? []) ? 'checked' : '' }}
                                    style="display:none;" class="interest-checkbox" id="int-{{ $cat->slug }}">
                                <span class="category-chip" id="chip-int-{{ $cat->slug }}" onclick="toggleChip('int-{{ $cat->slug }}','chip-int-{{ $cat->slug }}')"
                                    style="{{ in_array($cat->slug, $user->categories_of_interest ?? []) ? 'border-color:var(--purple);background:rgba(74,38,183,0.15);color:var(--text-main);' : '' }}">
                                    {{ $cat->icon }} {{ $cat->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label class="form-label">Display Preference</label>
                            <select name="display_preference" class="form-select">
                                <option value="grid" {{ $user->display_preference === 'grid' ? 'selected' : '' }}>Grid</option>
                                <option value="list" {{ $user->display_preference === 'list' ? 'selected' : '' }}>List</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Font Size</label>
                            <select name="font_size" class="form-select">
                                <option value="small"  {{ $user->font_size === 'small'  ? 'selected' : '' }}>Small (A-)</option>
                                <option value="medium" {{ $user->font_size === 'medium' ? 'selected' : '' }}>Medium (A)</option>
                                <option value="large"  {{ $user->font_size === 'large'  ? 'selected' : '' }}>Large (A+)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Theme</label>
                            <div style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;">
                                <input type="hidden" name="dark_mode" value="0">
                                <input type="checkbox" name="dark_mode" value="1" id="dark_mode" {{ $user->dark_mode ? 'checked' : '' }} style="accent-color:var(--purple);width:18px;height:18px;">
                                <label for="dark_mode" style="font-size:0.875rem;cursor:pointer;">Dark Mode</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>

            {{-- Change password --}}
            <div class="card" style="padding:2rem;">
                <h2 style="font-size:1rem;font-weight:700;margin-bottom:1.5rem;">Change Password</h2>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-input" required placeholder="••••••••">
                        @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-input" required placeholder="Min 8 characters">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-input" required placeholder="Repeat new password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Update Password</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatar-preview');
            const image = preview.querySelector('img') || document.createElement('img');
            image.src = e.target.result;
            image.alt = 'Avatar';
            image.style.cssText = 'width:100%;height:100%;object-fit:cover;';
            preview.replaceChildren(image);
        };
        reader.readAsDataURL(file);
        // Copy to form input
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('avatar-form-input').files = dt.files;
    }
}
function toggleChip(inputId, chipId) {
    const input = document.getElementById(inputId);
    const chip  = document.getElementById(chipId);
    input.checked = !input.checked;
    chip.style.borderColor  = input.checked ? 'var(--purple)' : 'var(--border)';
    chip.style.background   = input.checked ? 'rgba(74,38,183,0.15)' : 'var(--bg-card)';
    chip.style.color        = input.checked ? 'var(--text-main)' : 'var(--text-secondary)';
}
</script>
@endsection
