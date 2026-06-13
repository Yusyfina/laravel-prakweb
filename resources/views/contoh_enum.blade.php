    {{-- Di Blade View: tampilkan badge status
    <span class="badge bg-{{ $product->status->color() }}">
        <i class="bi {{ $product->status->icon() }} me-1"></i>
        {{ $product->status->label() }}
    </span>

    {{-- Select dengan Enum options --}}
    {{-- <select name="status" class="form-select">
        @foreach (\App\Enums\ProductStatus::cases() as $status)
            <option value="{{ $status->value }}"
                {{ old('status', $product->status->value ?? '') === $status->value ? 'selected' : '' }}
            >
                {{ $status->label() }}
            </option>
        @endforeach
    </select>
 --}}
