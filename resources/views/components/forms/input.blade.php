<div class="{{ $class }}">
    <label for="{{ $name }}" class="form-label">{{ $slot }}</label>
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror`" id="{{ $name }}"
        name="{{ $name }}" placeholder="{{ $slot }}" aria-describedby="{{ $name }}Help"
        value="{{ $value }}">
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
