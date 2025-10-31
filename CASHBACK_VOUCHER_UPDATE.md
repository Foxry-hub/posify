# 💰 VOUCHER CASHBACK - MINIMUM BELANJA UPDATE

## ✅ PERUBAHAN YANG DILAKUKAN

### Voucher Cashback dengan Minimum Belanja Baru

#### **Voucher Cashback Rp 10.000**
- **Sebelum**: Min. Belanja = Rp 0
- **Sesudah**: Min. Belanja = Rp 15.000 (Cashback + Rp 5.000)
- **Deskripsi**: "Potongan langsung Rp 10.000 untuk pembelian minimal Rp 15.000"

#### **Voucher Cashback Rp 25.000**
- **Sebelum**: Min. Belanja = Rp 0
- **Sesudah**: Min. Belanja = Rp 30.000 (Cashback + Rp 5.000)
- **Deskripsi**: "Potongan langsung Rp 25.000 untuk pembelian minimal Rp 30.000"

---

## 📊 KATALOG VOUCHER LENGKAP

| No | Nama Voucher | Poin | Diskon | Min. Belanja | Keterangan |
|----|--------------|------|--------|--------------|------------|
| 1 | Diskon 5% | 50 | 5% | Rp 50.000 | Diskon persentase |
| 2 | Diskon 10% | 100 | 10% | Rp 100.000 | Diskon persentase |
| 3 | **Cashback Rp 10K** | 150 | Rp 10.000 | **Rp 15.000** | Cashback + 5K |
| 4 | Diskon 15% | 200 | 15% | Rp 200.000 | Diskon persentase |
| 5 | **Cashback Rp 25K** | 300 | Rp 25.000 | **Rp 30.000** | Cashback + 5K |

---

## 🧪 TESTING SCENARIOS

### Scenario 1: Cashback Rp 10.000

#### ✅ VALID (Min. Purchase Met)
**Transaksi: Rp 15.000**
- Subtotal: Rp 15.000
- Diskon voucher: -Rp 10.000
- **Total bayar: Rp 5.000**
- Status: ✅ ACCEPTED

**Transaksi: Rp 20.000**
- Subtotal: Rp 20.000
- Diskon voucher: -Rp 10.000
- **Total bayar: Rp 10.000**
- Status: ✅ ACCEPTED

#### ❌ INVALID (Below Min. Purchase)
**Transaksi: Rp 14.999**
- Subtotal: Rp 14.999
- Diskon voucher: N/A
- **Error**: "Voucher memerlukan minimal pembelian Rp 15.000"
- Status: ❌ REJECTED

**Transaksi: Rp 10.000**
- Subtotal: Rp 10.000
- Diskon voucher: N/A
- **Error**: "Voucher memerlukan minimal pembelian Rp 15.000"
- Status: ❌ REJECTED

---

### Scenario 2: Cashback Rp 25.000

#### ✅ VALID (Min. Purchase Met)
**Transaksi: Rp 30.000**
- Subtotal: Rp 30.000
- Diskon voucher: -Rp 25.000
- **Total bayar: Rp 5.000**
- Status: ✅ ACCEPTED

**Transaksi: Rp 50.000**
- Subtotal: Rp 50.000
- Diskon voucher: -Rp 25.000
- **Total bayar: Rp 25.000**
- Status: ✅ ACCEPTED

#### ❌ INVALID (Below Min. Purchase)
**Transaksi: Rp 29.999**
- Subtotal: Rp 29.999
- Diskon voucher: N/A
- **Error**: "Voucher memerlukan minimal pembelian Rp 30.000"
- Status: ❌ REJECTED

**Transaksi: Rp 25.000**
- Subtotal: Rp 25.000
- Diskon voucher: N/A
- **Error**: "Voucher memerlukan minimal pembelian Rp 30.000"
- Status: ❌ REJECTED

---

## 🔍 VALIDASI DI POS

Ketika kasir menggunakan voucher cashback di POS, sistem akan:

1. **Cek Voucher Valid**: Status active, belum expired
2. **Cek Ownership**: Customer = pemilik voucher
3. **Cek Minimum Purchase**: 
   ```php
   if ($subtotal >= $voucher->min_purchase) {
       // OK - Apply diskon
   } else {
       // ERROR - Reject voucher
       return error("Voucher memerlukan minimal pembelian Rp X");
   }
   ```

---

## 📝 CARA TESTING

### Test 1: Redeem Voucher Cashback

**Langkah:**
1. Login sebagai member Rafa (081388088171 / 081388088171)
2. Buka: http://127.0.0.1:8000/pelanggan/member/redeem
3. Lihat katalog voucher
4. Voucher "Cashback Rp 10.000":
   - Poin: 150 poin
   - Min. Belanja: **Rp 15.000** (tertera di deskripsi)
5. Voucher "Cashback Rp 25.000":
   - Poin: 300 poin
   - Min. Belanja: **Rp 30.000** (tertera di deskripsi)

### Test 2: Gunakan Voucher Cashback Rp 10K (VALID)

**Langkah:**
1. Redeem voucher Cashback Rp 10K (butuh 150 poin)
2. Copy kode voucher (contoh: VCR-20251031-ABC123)
3. Login sebagai kasir
4. Buka POS
5. Input voucher code
6. Pilih customer (Rafa)
7. **Tambah produk total Rp 15.000 atau lebih**
8. Checkout

**Expected Result:**
- ✅ Transaksi berhasil
- ✅ Diskon: -Rp 10.000
- ✅ Message: "Transaksi berhasil! Diskon voucher: Rp 10.000"

### Test 3: Gunakan Voucher Cashback Rp 10K (INVALID)

**Langkah:**
1. Redeem voucher Cashback Rp 10K
2. Copy kode voucher
3. Login sebagai kasir
4. Buka POS
5. Input voucher code
6. Pilih customer (Rafa)
7. **Tambah produk total Rp 14.999 atau kurang**
8. Checkout

**Expected Result:**
- ❌ Error popup
- ❌ Message: "Voucher memerlukan minimal pembelian Rp 15.000"
- ❌ Transaksi tidak diproses
- ✅ Voucher tetap aktif (tidak ter-use)

### Test 4: Gunakan Voucher Cashback Rp 25K (VALID)

**Langkah:**
1. Redeem voucher Cashback Rp 25K (butuh 300 poin)
2. Login sebagai kasir
3. **Tambah produk total Rp 30.000 atau lebih**
4. Checkout

**Expected Result:**
- ✅ Transaksi berhasil
- ✅ Diskon: -Rp 25.000
- ✅ Total bayar minimal: Rp 5.000 (30K - 25K)

### Test 5: Gunakan Voucher Cashback Rp 25K (INVALID)

**Langkah:**
1. Redeem voucher Cashback Rp 25K
2. **Tambah produk total Rp 29.999 atau kurang**
3. Checkout

**Expected Result:**
- ❌ Error: "Voucher memerlukan minimal pembelian Rp 30.000"
- ❌ Transaksi tidak diproses

---

## 💡 LOGIC PENJELASAN

### Mengapa Cashback + Rp 5.000?

**Tujuan**: Mencegah total bayar menjadi terlalu kecil atau bahkan negatif.

**Contoh Tanpa Minimum:**
- Belanja: Rp 10.000
- Cashback: Rp 10.000
- Total: Rp 0 ❌ (Gratis!)

**Contoh Dengan Minimum (Cashback + 5K):**
- Min. Belanja: Rp 15.000
- Cashback: Rp 10.000
- Total Minimal: Rp 5.000 ✅ (Tetap bayar)

**Keuntungan:**
- Customer tetap harus bayar minimal Rp 5.000
- Toko tetap dapat revenue
- Customer tetap dapat benefit cashback

---

## 🎯 SUMMARY

| Voucher | Cashback | Min. Belanja | Selisih | Total Bayar Minimal |
|---------|----------|--------------|---------|---------------------|
| Cashback 10K | Rp 10.000 | Rp 15.000 | Rp 5.000 | Rp 5.000 |
| Cashback 25K | Rp 25.000 | Rp 30.000 | Rp 5.000 | Rp 5.000 |

**Formula:**
```
min_purchase = cashback_value + Rp 5.000
total_bayar_minimal = min_purchase - cashback_value = Rp 5.000
```

---

## ✅ VALIDATION CHECKLIST

- [x] Voucher Cashback 10K: min_purchase = Rp 15.000
- [x] Voucher Cashback 25K: min_purchase = Rp 30.000
- [x] Deskripsi voucher updated (tampilkan min. belanja)
- [x] Validasi di POS controller (sudah ada)
- [x] Error message jelas jika min. purchase tidak terpenuhi
- [x] Voucher tetap aktif jika transaksi ditolak

---

**READY TO TEST!** 🚀

Silakan test dengan:
1. Login sebagai Rafa (081388088171)
2. Redeem voucher cashback
3. Gunakan di POS dengan total < minimum → Error
4. Gunakan di POS dengan total >= minimum → Success
