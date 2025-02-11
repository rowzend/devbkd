<div class="row">
    <div class="mb-3 col-md-6">
        <label for="nama" class="form-label">Nama <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama"
            value="{{ isset($layanan) ? $layanan->nama : old('nama') }}" />
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="url" class="form-label">URL <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('url') is-invalid @enderror" type="text" name="url"
            value="{{ isset($layanan) ? $layanan->url : old('url') }}" />
        @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-12">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" cols="20" rows="7">{{ isset($layanan) ? $layanan->deskripsi : old('deskripsi') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @isset($layanan)
        <div class="mb-3 col-md-12">
            <div class="row">
                <div class="col-md-3">
                    @if ($layanan->thumbnail == null)
                        <label for="thumbnail" class="form-label">Gambar Lama</label>
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Thumbnail"
                            class="rounded mb-2 mt-2" alt="Thumbnail" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <label for="thumbnail" class="form-label">Gambar Lama</label>
                        <img src="{{ asset('storage/linkingpart/layanan/' . $layanan->thumbnail) }}" alt="Thumbnail"
                            class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="form-group ms-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input class="form-control  @error('thumbnail') is-invalid @enderror" type="file"
                            name="thumbnail" />
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mb-3 col-md-12">
            <label for="thumbnail" class="form-label">Thumbnail <span class="text-danger"> &#42;</span></label>
            <input class="form-control  @error('thumbnail') is-invalid @enderror" type="file" name="thumbnail" />
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endisset
</div>
