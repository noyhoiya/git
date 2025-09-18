@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">ຢືນຢັນອີເມວ</h5>

                    <p class="text-muted">
                        ກ່ອນທີ່ຈະເຂົ້າໃຊ້ລະບົບ, ກະລຸນາກວດອີເມວຂອງທ່ານ ແລະກົດລິ້ງຢືນຢັນບັນຊີ.  
                        ຖ້າທ່ານບໍ່ໄດ້ຮັບອີເມວ, ກົດປຸ່ມຂ້າງລຸ່ມເພື່ອສົ່ງລິ້ງໃໝ່.
                    </p>

                    {{-- Success message when link is re-sent --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            ✅ ພວກເຮົາໄດ້ສົ່ງລິ້ງຢືນຢັນໃໝ່ໄປຫາອີເມວຂອງທ່ານແລ້ວ!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            ສົ່ງລິ້ງຢືນຢັນໃໝ່
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
