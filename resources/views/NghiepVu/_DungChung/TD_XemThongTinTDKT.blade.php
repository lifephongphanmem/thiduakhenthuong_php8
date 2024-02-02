<button type="button" title="In dữ liệu"
    onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}', true)"
    class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal" data-toggle="modal">
    <i class="icon-lg la flaticon2-print text-dark"></i>
</button>

<button title="Tài liệu đính kèm" type="button"
    onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenThuong')"
    class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm" data-toggle="modal">
    <i class="icon-lg la la-file-download text-dark icon-2x"></i>
</button>
