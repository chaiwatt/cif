<table class="table table-borderless text-nowrap dataTable dtr-inline" id="userTable">
    <thead class="border-bottom">
        <tr>
            <th>#</th>
            <th>วันที่</th>
            <th>ชื่อ-สกุล</th>
            <th>แอคชั่น</th>
            <th>โมเดล</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logActivities as $key => $logActivity)
        <tr>
            <td>{{($key + 1 + $logActivities->perPage() *
                ($logActivities->currentPage() - 1))}}
            </td>
            <td>{{ $logActivity->created_at->format('d-m-Y H:i') }}</td>
            <td>{{$logActivity->user->name}} {{$logActivity->user->lastname}}
            </td>
            <td>{{$logActivity->action}}</td>
            <td>{{$logActivity->model}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $logActivities->links() }}