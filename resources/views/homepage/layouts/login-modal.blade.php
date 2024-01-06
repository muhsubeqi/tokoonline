<div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="login-modalLabel" class="modal-title">Login Member</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('login.supplier-member') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input id="email_modal" name="email" type="text" placeholder="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input id="password_modal" name="password" type="password" placeholder="password"
                            class="form-control">
                    </div>
                    <p class="text-center">
                        <button class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Log
                            in</button>
                    </p>
                </form>
                <p class="text-center text-muted">Belum punya akun?</p>
                <p class="text-center text-muted"><a href="{{ route('register.supplier-member') }}"><strong>Daftar
                            Sekarang</strong></a>! Dapatkan diskon pembelian 10%</p>
            </div>
        </div>
    </div>
</div>
