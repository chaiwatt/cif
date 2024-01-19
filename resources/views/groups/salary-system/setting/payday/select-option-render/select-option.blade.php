<div class="col-md-6">
    <div class="form-group">
        <label>รอบคำนวนต้น <span class="fw-bold text-danger">*</span></label>
        <select name="firstPayday" id="firstPayday" class="form-control select2" style="width: 100%;">
            <option value="">==เลือกรอบคำนวนต้น==</option>
            @foreach ($paydays as $payday)
            <option value="{{$payday->id}}">{{$payday->name}}</option>
            @endforeach
        </select>
        @error('firstPayday') <span class="text-sm mb-0 text-danger">*กรุณาเลือกรอบคำนวนต้น</span>
        @enderror

    </div>

</div>

<div class="col-md-6">
    <div class="form-group">
        <label>รอบคำนวนปลาย <span class="fw-bold text-danger">*</span></label>
        <select name="secondPayday" id="secondPayday" class="form-control select2" style="width: 100%;">
            <option value="">==เลือกรอบคำนวนปลาย==</option>
            @foreach ($paydays as $payday)
            <option value="{{$payday->id}}">{{$payday->name}}</option>
            @endforeach
        </select>
        @error('secondPayday') <span class="text-sm mb-0 text-danger">*กรุณาเลือกรอบคำนวนปลาย</span>
        @enderror
    </div>
</div>