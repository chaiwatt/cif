<div class="row">
    <input type="text" id="paydayDetailId" value="{{$paydayDetail->id}}" hidden>
    <div class="col-12">
        <div class="form-group">
            <label for="startDate">เริ่มวันที่ (วดป. คศ) <span class="fw-bold text-danger">*</span></label>
            <input type="text" class="form-control input-date-format" id="updateStartDate" value="{{\Carbon\Carbon::createFromFormat('Y-m-d',
                $paydayDetail->start_date)->format('d/m/Y')}}">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="endDate">ถึงวันที่ (วดป. คศ) <span class="fw-bold text-danger">*</span></label>
            <input type="text" class="form-control input-date-format" id="updateEndDate" value="{{\Carbon\Carbon::createFromFormat('Y-m-d',
                $paydayDetail->end_date)->format('d/m/Y')}}">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="paymentDate">วันที่จ่ายเงินเดือน (วดป. คศ) <span class="fw-bold text-danger">*</span></label>
            <input type="text" class="form-control input-date-format" id="updatePaymentDate" value="{{\Carbon\Carbon::createFromFormat('Y-m-d',
                $paydayDetail->payment_date)->format('d/m/Y')}}">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group text-end">
            <button type="button" class="btn btn-primary" id="update_payday">ตกลง</button>
        </div>
    </div>
</div>