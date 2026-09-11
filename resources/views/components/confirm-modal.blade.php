<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal-{{ $uid }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--earth-cream);border:1px solid var(--earth-light);border-radius:8px;">
            <div class="modal-header border-0" style="border-bottom:1px solid var(--earth-light);">
                <h5 class="modal-title" style="font-family:'Cormorant Garamond',serif;font-weight:600;color:var(--earth-dark);">Bevestigen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten" style="filter:invert(20%) sepia(30%) saturate(50%) hue-rotate(5deg);"></button>
            </div>
            <div class="modal-body">
                <p style="color:var(--earth-dark);">{{ $message ?? 'Weet je zeker dat je dit wilt verwijderen?' }}</p>
            </div>
            <div class="modal-footer border-0" style="border-top:1px solid var(--earth-light);">
                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Annuleren</button>
                <a href="{{ $url }}" class="btn btn-dark btn-sm" style="background:var(--earth-rust);border-color:var(--earth-rust);">Verwijderen</a>
            </div>
        </div>
    </div>
</div>
