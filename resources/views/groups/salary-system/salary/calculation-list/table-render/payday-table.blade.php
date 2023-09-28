<div class="card card-primary card-outline card-tabs">
    <div class="card-header p-0 pt-1 border-bottom-0">
        <div class="card-tools mt-2">
            <div class="input-group input-group-sm mt-1" style="width: 150px;">
                <select name="year" id="year" class="form-control " style="width: 100%;">
                    @foreach ($years as $year)
                    <option value="{{ $year}}" @if ($year==$selectedYear) selected @endif>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            @foreach ($paydays->where('type',1) as $key => $payday)
            <li class="nav-item">
                <a class="nav-link {{ $key === 0 ? 'active' : '' }}" id="custom-tabs-{{$payday->id}}-tab"
                    data-toggle="pill" href="#custom-tabs-{{$payday->id}}" role="tab"
                    aria-controls="custom-tabs-{{$payday->id}}" aria-selected="true">{{$payday->name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-three-tabContent">
            @foreach ($paydays->where('type',1) as $key => $payday)
            <div class="tab-pane fade show {{ $key === 0 ? 'active' : '' }}" id="custom-tabs-{{$payday->id}}"
                role="tabpanel" aria-labelledby="custom-tabs-{{$payday->id}}-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ต้นงวด</th>
                            <th>ปลายงวด</th>
                            <th>การคำนวน</th>
                            <th style="width: 100px">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payday->paydayDetails as $key => $paydayDetail)
                        @php

                        $startDate = \Carbon\Carbon::parse($paydayDetail->start_date);
                        $endDate = \Carbon\Carbon::parse($paydayDetail->end_date);
                        $currentMonth = \Carbon\Carbon::now()->month;
                        $paymentDate = \Carbon\Carbon::parse($paydayDetail->payment_date);
                        $currentDate = \Carbon\Carbon::now();
                        @endphp

                        @if ($startDate->month <= $currentMonth) <tr>
                            <td>

                                {{ $startDate->format('d/m/Y') }}
                                @if ($paymentDate->gte($currentDate) &&
                                $currentDate->gte($endDate))
                                <i class="fas fa-fire-alt text-danger"></i>
                                @endif
                            </td>
                            <td>{{ $endDate->format('d/m/Y') }}</td>
                            <td>
                                @if ($currentDate->gte($paymentDate))

                                <span class="badge bg-gray">หมดเวลา</span>
                                @elseif($paymentDate->gte($currentDate) &&
                                $currentDate->gte($endDate))

                                <span class="badge bg-success">อยู่ในช่วงทำรายการ</span>
                                @else
                                <span class="badge bg-warning">รอบต่อไป</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('groups.salary-system.salary.calculation-list.calculation',['id' => $paydayDetail->id])}}"
                                    class="btn btn-sm btn-info"><i class="fas fa-calculator"></i></a>
                                <a href="{{route('groups.salary-system.salary.calculation-list.summary',['id' => $paydayDetail->id])}}"
                                    class="btn btn-sm btn-success"><i class="fas fa-chart-bar"></i></a>
                            </td>
                            </tr>
                            @endif
                            @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
</div>