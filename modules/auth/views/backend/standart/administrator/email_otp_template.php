<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kode Verifikasi OTP - Vendio</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333; line-height: 1.6;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f6f9; padding: 30px 10px;">
    <tr>
      <td align="center">
        <!-- Main Card -->
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 520px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06); border-top: 5px solid #D7320C;">
          
          <!-- Header Logo -->
          <tr>
            <td align="center" style="padding: 30px 25px 20px 25px; border-bottom: 1px solid #f0f0f0;">
              <a href="<?= site_url(); ?>" target="_blank" style="text-decoration: none; display: inline-block;">
                <img src="<?= base_url('asset/img/icon-wide.png'); ?>" alt="Vendio" height="42" style="border: 0; outline: none; display: block; max-height: 42px;">
              </a>
            </td>
          </tr>

          <!-- Content Body -->
          <tr>
            <td style="padding: 30px 30px 20px 30px;">
              <h2 style="margin: 0 0 15px 0; font-size: 20px; color: #222222; font-weight: 700; text-align: center;">
                Verifikasi Pendaftaran Akun
              </h2>
              
              <p style="margin: 0 0 15px 0; font-size: 14px; color: #555555;">
                Halo <strong><?= !empty($full_name) ? html_escape($full_name) : 'Sahabat Vendio'; ?></strong>,
              </p>

              <p style="margin: 0 0 25px 0; font-size: 14px; color: #555555; line-height: 1.6;">
                Terima kasih telah mendaftarkan bisnis Anda di <strong>Vendio</strong>. Untuk memastikan keamanan akun dan menyelesaikan proses pendaftaran, silakan gunakan kode verifikasi (OTP) di bawah ini:
              </p>

              <!-- OTP Box -->
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 0 25px 0;">
                <tr>
                  <td align="center" style="background-color: #fff8f5; border: 2px dashed #D7320C; border-radius: 8px; padding: 18px 20px;">
                    <span style="font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #888888; font-weight: 600; display: block; margin-bottom: 6px;">
                      Kode OTP Anda
                    </span>
                    <span style="font-size: 34px; font-weight: 800; letter-spacing: 10px; color: #D7320C; font-family: 'Courier New', Courier, monospace; display: inline-block; padding-left: 10px;">
                      <?= html_escape($otp_code); ?>
                    </span>
                  </td>
                </tr>
              </table>

              <!-- Expiry Alert -->
              <div style="background-color: #fef9e7; border-left: 4px solid #f39c12; padding: 12px 15px; border-radius: 4px; margin-bottom: 25px;">
                <p style="margin: 0; font-size: 13px; color: #7d5a00; line-height: 1.5;">
                  ⏱️ Kode OTP ini berlaku selama <strong><?= !empty($expires_in) ? $expires_in : '15 menit'; ?></strong>. Demi keamanan, mohon <strong>jangan berikan</strong> kode ini kepada siapapun, termasuk pihak yang mengatasnamakan Vendio.
                </p>
              </div>

              <p style="margin: 0; font-size: 13px; color: #777777; line-height: 1.5;">
                Jika Anda tidak merasa melakukan pendaftaran di platform Vendio, silakan abaikan email ini dengan aman.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="padding: 20px 30px; background-color: #fafbfc; border-top: 1px solid #f0f0f0;">
              <p style="margin: 0 0 6px 0; font-size: 12px; color: #999999;">
                Email ini dikirim secara otomatis oleh sistem <strong>Vendio</strong>.
              </p>
              <p style="margin: 0; font-size: 11px; color: #bbbbbb;">
                &copy; <?= date('Y'); ?> Vendio - Solusi Multi-Tenant & Omnichannel Commerce. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
