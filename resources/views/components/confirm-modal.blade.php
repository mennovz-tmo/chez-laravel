<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal-{{ $uid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-custom">
            <div class="modal-header modal-header-custom border-0">
                <h5 class="modal-title modal-title">Bevestigen</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Sluiten"
                    class="close-btn"
                ></button>
            </div>
            <div class="modal-body">
                <p class="dropdown-link">{{ $message ?? 'Weet je zeker dat je dit wilt verwijderen?' }}</p>
            </div>
            <div class="modal-footer modal-footer-custom border-0">
                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Annuleren</button>
                <form method="post" action="{{ $url }}">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm btn-rust">Verwijderen</button>
                </form>
            </div>
        </div>
    </div>
</div>
