<div class="col-md-12">
    <div class="form-group">
        <label>เบี้ยขยัน <span class="fw-bold text-danger">*</span></label>
        <select id="diligence-allowance-classify" class="form-control select2" style="width: 100%;">
            @foreach ($diligenceAllowanceClassifies as $diligenceAllowanceClassify)
            <option value="{{ $diligenceAllowanceClassify->id }}">
                {{ $diligenceAllowanceClassify->cost }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="cif-modal-footer m-0">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary" id="save-update-user-diligence-allowance">แก้ไข</button>
</div>