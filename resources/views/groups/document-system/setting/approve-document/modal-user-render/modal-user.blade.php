<div class="form-group">
    <label>ผู้อนุมัติ</label>
    <select name="user" id="user" class="form-control select2 @error('user') is-invalid @enderror" style="width: 100%;">
        <option value="">==เลือกผู้อนุมัติ==</option>
        @foreach ($users as $user)
        <option value="{{ $user->id }}" {{ old('user')==$user->id ?'selected' : '' }}>
            {{ $user->name }} {{ $user->lastname }}
        </option>
        @endforeach
    </select>
</div>

<script>
    $(function () {
        $('.select2').select2()
    });

</script>