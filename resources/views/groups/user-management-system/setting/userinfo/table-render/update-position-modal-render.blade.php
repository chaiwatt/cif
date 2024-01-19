<div class="col-12">
    <input type="text" name="" id="positionHistoryId" value="{{$positionHistory->id}}" hidden>
    <div class="form-group">
        <label>วันที่ปรับ (วดป. คศ) <span class="fw-bold text-danger">*</span></label>
        <input type="text" class="form-control input-date-format" id="update-position-adjustment-date"
            value="{{ date('d/m/Y', strtotime($positionHistory->adjust_date)) }}">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label>ตำแหน่ง <span class="fw-bold text-danger">*</span></label>
        <select id="update-position" class="form-control select2" style="width: 100%;">
            @foreach ($userPositions as $position)
            <option value="{{ $position->id }}" {{ $position->id ==
                $positionHistory->user_position_id ? 'selected' : '' }}>
                {{ $position->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-12">
    <div class="form-group text-end">
        <button type="button" class="btn btn-primary" id="save-update-position">แก้ไข</button>
    </div>
</div>