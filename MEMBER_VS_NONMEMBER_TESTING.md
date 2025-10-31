# 🔒 SISTEM POIN MEMBER vs NON-MEMBER - TESTING GUIDE

## ✅ PERUBAHAN YANG SUDAH DILAKUKAN

### 1. **Logic Poin (Backend)**
- ✅ **NON-MEMBER**: Tidak akan mendapat poin setelah transaksi
- ✅ **MEMBER**: Mendapat poin otomatis setelah transaksi (1 poin per Rp 10K)
- ✅ Logic sudah ada di `TransactionController@store()`:
  ```php
  if ($transaction->customer_id) {
      $member = Member::where('user_id', $transaction->customer_id)->first();
      if ($member && $member->isActive()) {
          $pointsEarned = $member->addPointsFromTransaction($transaction);
      }
  }
  ```

### 2. **Dashboard Pelanggan (Frontend)**

#### A. Quick Actions - Tombol Member
**MEMBER (Aktif):**
- Warna: Gradient kuning-orange (yellow-500 to orange-500)
- Icon: Bintang (star)
- Text: "Member"
- Sub-text: "X Poin"
- Status: Clickable → menuju Member Dashboard
- Hover: Shadow & translate effect

**NON-MEMBER (Terkunci):**
- Warna: Gradient abu-abu (gray-400 to gray-500)
- Icon: Bintang (star) dengan opacity 60%
- Lock Icon: Gembok di kanan atas
- Text: "Member"
- Sub-text: "Belum Terdaftar"
- Status: cursor-not-allowed, opacity-75
- Tidak bisa diklik

#### B. Card Poin Reward
**MEMBER:**
- Badge: "✓ Member" (hijau)
- Poin: Angka aktual dari database
- Sub-text: "Poin tersedia"

**NON-MEMBER:**
- Badge: "🔒 Non-Member" (abu-abu)
- Poin: 0 (warna abu-abu)
- Sub-text: "Daftar member untuk dapat poin"

#### C. Info Program Reward
**MEMBER:**
- Text: "Kumpulkan poin setiap pembelian dan dapatkan diskon menarik!"
- Status: "✓ Anda sudah terdaftar sebagai member"
- Link: "Lihat Member Dashboard →"

**NON-MEMBER:**
- Text: "Dapatkan poin setiap pembelian minimal Rp 10.000!"
- Keuntungan Member:
  - ✓ Dapat poin setiap belanja (Rp 10K = 1 poin)
  - ✓ Tukar poin dengan voucher diskon
  - ✓ Promo eksklusif member
- Cara Daftar: "Hubungi kasir saat berbelanja untuk mendaftar sebagai member"

---

## 🧪 CARA TESTING

### Test 1: Login sebagai NON-MEMBER

**Credentials:**
```
URL: http://127.0.0.1:8000/login
Email: nonmember@test.com
Password: password123
```

**Yang Harus Terlihat:**
1. ✅ Quick Actions: Tombol "Member" dengan:
   - Icon gembok di kanan atas
   - Warna abu-abu
   - Text "Belum Terdaftar"
   - Tidak bisa diklik (cursor not-allowed)

2. ✅ Card "Poin Reward":
   - Badge "🔒 Non-Member" (abu-abu)
   - Poin: 0 (warna abu-abu)
   - Text: "Daftar member untuk dapat poin"

3. ✅ Info "Program Reward Member":
   - Keuntungan member dijelaskan
   - Cara daftar: "Hubungi kasir..."

### Test 2: Transaksi sebagai NON-MEMBER

**Langkah:**
1. Login sebagai kasir (`kasir@valstore.com` / `password123`)
2. Buka POS: http://127.0.0.1:8000/kasir/transactions/create
3. Pilih customer: "Pelanggan Non-Member" (atau input manual)
4. Tambah produk (misal total Rp 50,000)
5. Checkout & bayar

**Expected Result:**
- ✅ Transaksi berhasil
- ❌ **TIDAK ADA** pesan "Member mendapat X poin"
- ❌ Customer **TIDAK DAPAT** poin sama sekali

**Verifikasi:**
- Login lagi sebagai `nonmember@test.com`
- Cek dashboard → Poin tetap 0
- Cek riwayat → Transaksi ada, tapi poin 0

### Test 3: Login sebagai MEMBER (Rafa)

**Credentials:**
```
URL: http://127.0.0.1:8000/login
Phone: 081388088171
Password: 081388088171
```

**Yang Harus Terlihat:**
1. ✅ Quick Actions: Tombol "Member" dengan:
   - Warna kuning-orange (gradient)
   - Icon bintang (tanpa gembok)
   - Text "Member"
   - Sub-text: "8 Poin" (atau berapa poin saat ini)
   - Bisa diklik → menuju Member Dashboard

2. ✅ Card "Poin Reward":
   - Badge "✓ Member" (hijau)
   - Poin: 8 (atau berapa poin aktual)
   - Text: "Poin tersedia"

3. ✅ Info "Program Reward Member":
   - Text: "✓ Anda sudah terdaftar sebagai member"
   - Link: "Lihat Member Dashboard →"

### Test 4: Transaksi sebagai MEMBER

**Langkah:**
1. Login sebagai kasir
2. Buka POS
3. Scan member Rafa (phone: 081388088171) ATAU pilih dari dropdown
4. Tambah produk (misal total Rp 50,000)
5. Checkout & bayar

**Expected Result:**
- ✅ Transaksi berhasil
- ✅ Pesan: "Transaksi berhasil! Member mendapat 5 poin."
- ✅ Poin Rafa bertambah dari 8 → 13

**Verifikasi:**
- Login lagi sebagai Rafa (081388088171)
- Cek dashboard → Poin bertambah jadi 13
- Cek Member Dashboard → History poin ada record baru

### Test 5: Upgrade NON-MEMBER menjadi MEMBER

**Langkah:**
1. Login sebagai kasir
2. Buka POS
3. Scan member dengan phone `08123456999`
4. Akan muncul: "Pelanggan belum menjadi member"
5. Klik "Daftarkan Sebagai Member"
6. Konfirmasi

**Expected Result:**
- ✅ User "Pelanggan Non-Member" sekarang jadi member
- ✅ Dapat member code (MBR-YYYYMMDD-XXXXXX)

**Verifikasi:**
- Login lagi sebagai `nonmember@test.com`
- Dashboard sekarang menampilkan:
  - Tombol Member: Kuning-orange (bisa diklik)
  - Poin: 0 (tapi sudah member)
  - Badge: "✓ Member"
- Lakukan transaksi baru → SEKARANG DAPAT POIN!

---

## 📊 COMPARISON TABLE

| Fitur | NON-MEMBER | MEMBER |
|-------|-----------|--------|
| **Dapat Poin dari Transaksi** | ❌ Tidak | ✅ Ya (1 poin/10K) |
| **Tombol Member di Dashboard** | 🔒 Terkunci (abu-abu) | ⭐ Aktif (kuning-orange) |
| **Badge Poin** | "🔒 Non-Member" | "✓ Member" |
| **Total Poin** | 0 (abu-abu) | Angka aktual (hitam) |
| **Akses Member Dashboard** | ❌ Tidak bisa | ✅ Bisa |
| **Tukar Poin Voucher** | ❌ Tidak bisa | ✅ Bisa |
| **Gunakan Voucher di POS** | ❌ Tidak bisa | ✅ Bisa |
| **Cara Upgrade** | Hubungi kasir | - |

---

## 🎯 EXPECTED BEHAVIOR

### Skenario 1: Non-Member Belanja Rp 100,000
- Subtotal: Rp 100,000
- Total bayar: Rp 100,000
- **Poin didapat: 0**
- Message: "Transaksi berhasil!"

### Skenario 2: Member Belanja Rp 100,000
- Subtotal: Rp 100,000
- Total bayar: Rp 100,000
- **Poin didapat: 10** (floor(100000 / 10000))
- Message: "Transaksi berhasil! Member mendapat 10 poin."

### Skenario 3: Non-Member Upgrade → Belanja
1. Saat ini non-member, belanja Rp 50K → Poin: 0
2. Kasir upgrade jadi member
3. Belanja lagi Rp 50K → Poin: 5 (dapat poin!)
4. Total poin: 5 (transaksi sebelum upgrade TIDAK dapat poin retroaktif)

---

## 🐛 EDGE CASES

### Case 1: Transaksi Tanpa Customer
- Customer: "Umum" (customer_id = null)
- **Poin: 0** (tidak ada customer)
- ✅ CORRECT

### Case 2: Customer Terdaftar tapi Bukan Member
- Customer: User pelanggan yang belum di-upgrade
- customer_id: Ada
- member: Tidak ada
- **Poin: 0**
- ✅ CORRECT

### Case 3: Member dengan Transaksi < Rp 10,000
- Customer: Member aktif
- Transaksi: Rp 8,000
- **Poin: 0** (floor(8000 / 10000) = 0)
- ✅ CORRECT

### Case 4: Member Tidak Aktif (status = 'inactive')
- Customer: Member dengan status inactive
- **Poin: 0** (dicek dengan `$member->isActive()`)
- ✅ CORRECT

---

## ✅ CHECKLIST TESTING

**Non-Member:**
- [ ] Login sebagai nonmember@test.com
- [ ] Dashboard menampilkan tombol Member terkunci (abu-abu + gembok)
- [ ] Card Poin Reward: "0" dengan badge "Non-Member"
- [ ] Info: Cara daftar member dijelaskan
- [ ] Lakukan transaksi via kasir (Rp 50K)
- [ ] Transaksi berhasil tanpa poin
- [ ] Cek dashboard lagi → Poin tetap 0

**Member:**
- [ ] Login sebagai member (Rafa: 081388088171)
- [ ] Dashboard menampilkan tombol Member aktif (kuning-orange)
- [ ] Card Poin Reward: Angka poin aktual dengan badge "Member"
- [ ] Tombol Member bisa diklik → menuju Member Dashboard
- [ ] Lakukan transaksi via kasir (Rp 50K)
- [ ] Transaksi berhasil dengan pesan "Member mendapat 5 poin"
- [ ] Cek dashboard lagi → Poin bertambah +5
- [ ] Cek Member Dashboard → History poin terupdate

**Upgrade:**
- [ ] Login sebagai kasir
- [ ] Scan non-member (08123456999)
- [ ] Muncul tombol "Daftarkan Sebagai Member"
- [ ] Klik upgrade → Member created
- [ ] Login lagi sebagai user tersebut
- [ ] Dashboard sekarang menampilkan Member aktif
- [ ] Lakukan transaksi → DAPAT POIN!

---

## 🚀 STATUS: COMPLETE!

**Semua fitur sudah selesai:**
- ✅ Non-member tidak dapat poin
- ✅ Dashboard menampilkan status member dengan jelas
- ✅ Tombol Member dengan icon terkunci untuk non-member
- ✅ Card Poin Reward dengan badge yang berbeda
- ✅ Info cara mendaftar member untuk non-member
- ✅ Member dapat poin otomatis setelah transaksi

**Silakan test dengan user:**
1. **Non-Member**: nonmember@test.com / password123
2. **Member**: 081388088171 / 081388088171

---

**READY TO TEST!** 🎉
