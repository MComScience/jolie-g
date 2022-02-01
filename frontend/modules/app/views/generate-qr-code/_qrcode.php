<table class="items" width="100%" cellpadding="0" border="0">
    <tbody>
        <?php foreach ($items as $subitems) { ?>
            <tr style="margin:0;padding:0;line-height:0;">
                <?php foreach ($subitems as $item) { ?>
                    <td style="text-align:center;padding:0;height:3cm;vertical-align: middle;margin:0; border: 1px solid #ffffff;line-height:0;">
                        <p style="margin:0;margin-top:1mm;">แสกนเพื่อลุ้นรับรางวัล</p>
                        <p style="margin:0;padding:0;">
                            <barcode code="<?= $item['url'] ?>" type="QR" class="barcode" size="<?= $qrSize ?>" error="M" disableborder="1" style="width:2.2cm;height:2.2cm;margin-bottom:1.5mm;" />
                        </p>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>