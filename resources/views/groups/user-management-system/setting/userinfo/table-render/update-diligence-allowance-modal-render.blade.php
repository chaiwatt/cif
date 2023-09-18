<div class="col-md-12">
    <div class="form-group">
        <label>เบี้ยขยัน<span class="small text-danger">*</span></label>
        <select id="diligence-allowance-classify" class="form-control select2" style="width: 100%;">
            @foreach ($diligenceAllowanceClassifies as $diligenceAllowanceClassify)
            <option value="{{ $diligenceAllowanceClassify->id }}">
                {{ $diligenceAllowanceClassify->cost }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-12">
    <div class="form-group float-right">
        <button type="button" class="btn btn-primary" id="save-update-user-diligence-allowance">แก้ไข</button>
    </div>
</div>