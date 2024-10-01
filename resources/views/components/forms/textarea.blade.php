<div class="{{ $class }}">
    <label for="{{ $name }}" class="form-label">{{ $slot }}</label>
    <textarea class="form-control @error($name) is-invalid @enderror`" id="{{ $name }}" name="{{ $name }}"
        placeholder="{{ $slot }}" aria-describedby="{{ $name }}Help">{{ $value }}</textarea>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
