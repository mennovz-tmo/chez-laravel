<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal-{{ $uid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-custom">
            <div class="modal-header border-0 modal-header-custom">
                <h5 class="modal-title modal-title">Bevestigen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten"
                    class="close-btn"></button>
            </div>
            <div class="modal-body">
                <p class="dropdown-link">{{ $message ?? 'Weet je zeker dat je dit wilt verwijderen?' }}</p>
            </div>
            <div class="modal-footer border-0 modal-footer-custom">
                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Annuleren</button>
                <a href="{{ $url }}" class="btn btn-dark btn-sm btn-rust">Verwijderen</a>
            </div>
        </div>
    </div>
</div>