{!! Form::open(['route' => $url['store'], 'method' => 'POST', 'id' => 'dform']) !!}
<div class="col-12 mb-3">
    <div class="form-floating form-floating-outline">
        <input type="text" id="name" name="name" class="form-control" placeholder="Enter a role name"
            tabindex="-1" />
        <label for="name">Role Name</label>
    </div>
</div>
<div class="col-12">
    <h5 class="mb-6">Role Permissions</h5>
    <!-- Permission table -->
    <div class="table-responsive">
        <table class="table table-flush-spacing">
            <tbody>
                @foreach ($data['list_permission_group'] as $permissionName => $permission)
                    <tr>
                        <td class="text-nowrap fw-medium" width="50%">{{ ucwords($permissionName) }}</td>
                        <td width="3%">
                            <div class="d-flex justify-content-start">
                                @foreach ($permission as $permissionId => $item)
                                    <div class="form-check mb-0 mt-1 me-4 me-lg-12">
                                        <input class="form-check-input" name="permission[{{ $permissionId }}]"
                                            type="checkbox" id="permission-{{ $permissionId }}" />
                                        <label class="form-check-label"
                                            for="userManagementRead">{{ strtoupper($item) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Permission table -->
</div>
<div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
        Cancel
    </button>
</div>
{!! Form::close() !!}
