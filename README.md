# NutriPlate - Recipe Service
NutriPlate Recipe Service adalah microservice yang bertugas mengelola dan menyediakan **data katalog resep** beserta **komposisi bahannya (ingredients)** kepada client. Service ini dibuat menggunakan framework CodeIgniter 4, lalu dikemas dalam Docker Container untuk isolasi sistem, dan dijalankan pada perangkat STB. Layanan ini menyediakan akses data melalui RESTful API yang diamankan dengan mekanisme otentikasi X-API-KEY. 

---

## Akses Publik (Deployment)
Akses publik menggunakan Cloudflare Tunnel (Zero Trust) dan dapat diakses secara publik melalui:

https://recipes.otwdochub.my.id

---

## Teknologi Stack
- PHP 8.2  
- CodeIgniter 4  
- SQLite3 
- Docker & Docker Compose
- STB B860H (Armbian Linux)
- Cloudflare Zero Trust (Tunnel)

---

## Autentikasi 
Layanan ini menggunakan mekanisme **Custom API Key Authentication**. 

Setiap request ke endpoint tertentu **wajib input header berikut**:

| Header Name | Value |
|------------|-------|
| `X-API-KEY` | `belin123` |

Jika API Key tidak valid atau tidak disertakan, server akan merespons dengan status **401 Unauthorized**.

---

## Dokumentasi API (Endpoints)

Berikut adalah daftar endpoint yang tersedia.

### A. Mendapatkan Semua Resep (`GET /recipes`)
Mengambil seluruh daftar resep yang tersedia di database.

* **URL:** `/recipes`
* **Method:** `GET`
* **Auth:** Wajib (`X-API-KEY: belin123`)

#### Contoh Response Sukses (200 OK)

```json
[
  {
    "recipe_name": "Mulligatawny Soup",
    "ingredients": "chicken, rice, celery, apple, butter, flour",
    "matched_ingredients": "chicken, rice, celery, apple, butter, flour"
  },
  {
    "recipe_name": "Waldorf Salad",
    "ingredients": "apples, celery, walnuts, raisins, mayonnaise, lemon juice",
    "matched_ingredients": "apples, celery, walnuts, raisins, mayonnaise, lemon juice"
  }
]
```

<img width="1442" height="883" alt="image" src="https://github.com/user-attachments/assets/0728a4ec-eb72-45ce-9624-ede3b8cd7bde" />

#### Contoh Response Gagal (401 Unauthorized)

```json
{
  "status": 401,
  "error": 401,
  "messages": {
    "error": "Maaf, API Key tidak valid untuk melihat resep."
  }
}
```

<img width="1460" height="618" alt="image" src="https://github.com/user-attachments/assets/911afae9-8395-466c-a137-61f6720b68c7" />

### B. Mendapatkan Detail Resep (GET /recipes/{recipe_name})

Mengambil detail satu resep spesifik berdasarkan **nama resep**.  
Nama resep pada URL **harus di-encode** jika mengandung spasi  
(contoh: spasi menjadi `%20`).

- **URL:** `/recipes/{recipe_name}`  
  Contoh: `/recipes/Mulligatawny%20Soup`
- **Method:** `GET`

#### Contoh Response Sukses (200 OK)

```json
{
  "recipe_name": "Mulligatawny Soup",
  "ingredients": "chicken, rice, celery, apple, butter, flour",
  "matched_ingredients": "chicken, rice, celery, apple, butter, flour",
  "ingredients_list": [
    "chicken",
    "rice",
    "celery",
    "apple",
    "butter",
    "flour"
  ]
}
```

<img width="1445" height="758" alt="image" src="https://github.com/user-attachments/assets/1118a749-01a7-4ddf-bae6-c1ccd388820e" />

#### Contoh Response Jika Tidak Ditemukan (404 Not Found)
```json
{
  "status": 404,
  "error": 404,
  "messages": {
    "error": "Resep dengan nama \"Nasi Goreng\" tidak ditemukan."
  }
}
```
<img width="1451" height="649" alt="image" src="https://github.com/user-attachments/assets/d349a6b8-0a7f-4113-a14f-bfa6d57e32cc" />

---

## Cara Menjalankan (Local)

**1. Clone Repository**
```bash
git clone https://github.com/vincentiabelindaa/uas-tst-recipe.git
cd uas-tst-recipe
```
**2. Jalankan Service**
```bash
docker-compose up -d --build
```
**3. Akses Service**

Service dapat diakses melalui browser di: http://localhost:8080/recipes

---

## Menggunakan cURL
```bash
curl -X GET https://recipes.otwdochub.my.id/recipes \
  -H "X-API-KEY: belin123"
```
