<!-- fix -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>  
    <title>Perwira Crypto</title>
<link rel="icon" href="{{ asset('assets/images/icon.svg') }}" type="image/svg+xml">

    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Roboto&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{('assets/css/landing.css')}}" />
  </head>
  <body class="bg-[#021028] text-white w-screen flex justify-center items-center flex-col">
    <main class=" main-content min-w-[375px] w-[100%] max-w-7xl flex flex-col items-center pt-[40px] pb-[120px]">

        <!-- Neon Lines -->
    <div
      class="absolute top-[50px] left-[30px] w-[20%] h-[20px] bg-gradient-to-r from-white to-[#191970] rounded-[10px] blur-[10px]"
    ></div>
    <div
      class="absolute top-[50px] right-[30px] w-[20%] h-[20px] bg-gradient-to-r from-white to-[#191970] rounded-[10px] blur-[10px]"
    ></div>
    <div
      class="absolute top-[100px] left-[30px] w-[30%] h-[20px] bg-gradient-to-r from-white to-[#191970] rounded-[10px] blur-[10px]"
    ></div>
    <div
      class="absolute top-[100px] right-[30px] w-[30%] h-[20px] bg-gradient-to-r from-white to-[#191970] rounded-[10px] blur-[10px]"
    ></div>

      <!-- logo -->
      <div class="container">
        <a href="{{ ('/') }}">
            <div class="logo flex flex-col justify-center items-center">
            <img
                src="{{ ('assets/images/icon-50%.svg') }}"
                alt="Perwira Crypto"
                class="w-[81px] h-[104px]"
            />
            <span class="text-center font-open-sans font-bold"
                >PERWIRA <br />
                CRYPTO</span
            >
            </div>
        </a>
      </div>

      <!-- button signin register -->
      <div
        class="container flex flex-row justify-center gap-20 items-center mt-[60px]"
      >
        <a href="{{ route('login') }}">
          <button
            class="slide-in-left bt-sr w-[216px] max-w-[216px] h-[75px] max-h-[75px] text-xl border-none bg-[#0c1b3a] btn-shadow drop-shadow-[10px_10px_16px_#7eb6ff31]"
          >
            Log In
          </button>
        </a>

        <a href="{{ route('register') }}">
          <button
            class="slide-in-right bt-sr w-[216px] max-w-[216px] h-[75px] max-h-[75px] text-xl border-none bg-[#0c1b3a] btn-shadow drop-shadow-[10px_10px_16px_#7eb6ff31]"
          >
            Sign Up
          </button>
        </a>
      </div>

      <!-- discord button -->
      <div
        class="fade-in-section container flex flex-row justify-center items-center mt-[60px]"
      >
        <a
          href="https://discord.com/invite/aFfH5XtvXA?fbclid=PAZXh0bgNhZW0CMTEAAafww6GTkLrV5P5WcsoMcDOibtNbnD_r2NxjIHQNuKID5MzMQbb7pejWYn1wmQ_aem_F86YJWxeYympU2yp1ddx9Q"
          target="_blank"
        >
          <button
            class="w-[306px] h-[51px] flex justify-center items-center gap-6 rounded-5px bg-[radial-gradient(circle_at_center,_#8a9ae9_19%_,#4a5484_81%)] rounded-[5px]"
          >
            <img
              class="w-[41px] h-[41px]"
              src="https://cdn-icons-png.flaticon.com/512/3670/3670157.png"
              alt="Discord Perwira Crypto"
            />
            <span>Join Komunitas Kita</span>
          </button>
        </a>
      </div>

      <!-- main text -->
      <div class="container mt-[60px] text-center">
        <h2
          class="fade-in-section text-4xl font-bold font-open-sans text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed"
        >
          PERWIRA CRYPTO EXCLUSIVE WOLF PACK <br />
          PERTAMA DI INDONESIA.BELAJAR <br />
          TRADING DARI ILMU SEJATINYA SERIGALA
        </h2>

        <p class="mt-[40px] font-light font-open-sans fade-in-section">
          Ratusan orang sudah membuktikan:<br />
          Belajar trading dari 0, ngerti pasar, dan bisa ngelawan
          ketidakpastian.<br />
          Tanpa janji kosong, jual mimpi dan sinyal-sinyal sampah.
        </p>

        <a href="{{ route('register') }}">
            <button
            class="fade-in-section  mt-[40px] w-[280px] h-[60px] text-xl bg-gradient-to-b from-[#2b59d3] to-[#1b336c] text-white font-semibold font-orbitron rounded-lg hover:scale-[1.1] duration-500"
            >
            Join Kita Sekarang
            </button>
        </a>
      </div>

      <div class="container mt-[120px] text-center">
        <img
          class="slide-in-right w-[30%] absolute left-0 h-[3px] mt-[25px]"
          src="{{('assets/images/misc/left-why.png')}}"
          alt=""
        />
        <img
          class="slide-in-left w-[30%] absolute right-0 h-[3px] mt-[25px]"
          src="{{('assets/images/misc/right-why.png')}}"
          alt=""
        />
        <h6
          class="fade-in-section main-text tracking-wide font-roboto font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] "
        >
          MENGAPA HARUS PERWIRA CRYPTO
        </h6>
      </div>

      <div class="container mt-[60px] text-center fade-in-section">
        <h4
          class="font-bold text-3xl tracking-wider font-open-sans text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed"
        >
          Visi Kita Mencetak Serigala-serigala baru di market
        </h4>
        <p class="text-gray-300 font-open-sans mt-[20px] text-lg mb-[20px]">
          99% Traders Gagal Tapi Kita memiliki ilmu sejati 1% traders sukses
          yang <br />
          disebut serigala
        </p>
        <p
          class="mb-[40px] text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed"
        >
          #WolfPrinciples
        </p>
      </div>

      <hr class="slide-in-right h-[1px] w-full bottom-[50px] bg-gradient-to-r from-gray-800 via-blue-500 to-gray-800 border-0 rounded-full my-6">

      <div class="container mt-[120px]">
        <div class="grid grid-cols-12">
          <div class="slide-in-down">
            <div class="transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)] md:left-[25%] md:top-[10px] lg:left-[25%] lg:top-[10px]"></div>
            <div class="w-[1px] h-[120%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
          </div>
          <div class="col-span-11 slide-in-left">
            <p class="font-semibold text-lg text-blue-400 mb-2 ">
              Mempelajari skill mahal di industri masa depan
              <br class="block lg:hidden" />
              (Anyone dream job)
            </p>
            <p class="leading-relaxed font-open-sans">
              Tanpa jadwal kerja <br />
              <ul class="font-light font-open-sans list-inside" style="list-style-type: '-  '">
                <li>Tanpa bos </li>
                <li>Penghasilan tidak terbatas (unlimited money)</li>
                <li>Tanpa kantor, bisa kerja dikasur terus tidur tapi duit masuk terus</li>
                <li>Tidak ada rekan kerja yang annoying</li>
                <li>Tanpa strategi rumit menggunakan pendekatan ‘semakin sedikit semakin
              efektif’</li>
              </ul>
            </p>
          </div>
        </div>
      </div>

      <div class="container mt-[40px]">
        <div class="grid grid-cols-12">
          <div class="slide-in-down">
            <div class="transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)] md:left-[25%] md:top-[10px] lg:left-[25%] lg:top-[10px]"></div>
            <div class="w-[1px] h-[100%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
          </div>
          <div class="col-span-11 slide-in-left">
            <p class="font-semibold text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
              Value kita yang tidak bisa dibeli di tempat lain
            </p>
          </div>
        </div>
      </div>

      <div class="container hide-m slide-in-left">
        <div class="h-[1px] w-[50%] mt-[20px] bg-gradient-to-r from-blue-900 to-purple-700"></div>
      </div>

      <div class="sc-z container flex justify-center">
        <div class="text-right w-[49%] pr-4 pt-6">
          <p class="text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            Komunitas eksklusif inner circle para serigala
          </p>
        </div>

        <div class="w-[2%] flex flex-col items-center justify-center slide-in-down">
          <div class=" mt-[40px] ml-[20px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
          <div class=" mt-[-60px] w-[1px] h-[120%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
        </div>

        <div class="text-left w-[49%] pl-4 pt-6">
          <p class="font-semibold text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            Ini bukan sekedar kelas, tetapi <br />
            community base gerakan revolusi masa depan keuangan
          </p>
        </div>
      </div>

      <div class="sc-z container flex justify-center">
        <div class="text-right w-[49%] pr-4 pt-20 slide-in-left">
          <p class="text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            Copy Trade / Sinyal Trading Terbaik di Indonesia dengan Winrate 90%+
          </p>
        </div>

        <div class="w-[2%] flex flex-col items-center justify-center slide-in-down">
          <div class=" mt-[90px] ml-[20px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
          <div class=" mt-[-110px] w-[1px] h-[120%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
        </div>

        <div class="text-left w-[49%] pl-4 pt-20">
          <div class="p-[2px] bg-gradient-to-r from-blue-900 via-blue-400 to-green-100 rounded-md slide-in-right">
          <div class="h-[140px] grid grid-cols-4 gap-0 bg-white rounded-md overflow-hidden">
            <img src="{{('assets/foto_1.jpg')}}" alt="Foto 1" class="object-cover w-full h-full">
            <img src="{{('assets/foto_2.jpg')}}" alt="Foto 2" class="object-cover w-full h-full">
            <img src="{{('assets/foto_3.jpg')}}" alt="Foto 3" class="object-cover w-full h-full">
            <img src="{{('assets/foto_5.jpg')}}" alt="Foto 4" class="object-cover w-full h-full">
          </div>
        </div>
        </div>
      </div>


      <div class="sc-z container flex justify-center">
        <div class="text-right w-[49%] pr-4 pt-20 slide-in-left">
          <p class="text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            Kalian akan mempunyai pandangan yang jelas untuk arah market. Tahu kapan harus membeli dan menjual. <br>(Perwira Crypto Trading System)
          </p>
        </div>

        <div class="w-[2%] flex flex-col items-center justify-center slide-in-down">
          <div class=" mt-[90px] ml-[20px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
          <div class=" mt-[-110px] w-[1px] h-[120%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
        </div>

        <div class="text-left w-[49%] pl-4 pt-20">
          <div class="p-[2px] bg-gradient-to-r from-blue-900 via-blue-400 to-green-100 rounded-md slide-in-right">
          <div class="h-[140px] grid grid-cols-4 gap-0 bg-white rounded-md overflow-hidden">
            <img src="{{('assets/foto_1.jpg')}}" alt="Foto 1" class="object-cover w-full h-full">
            <img src="{{('assets/foto_2.jpg')}}" alt="Foto 2" class="object-cover w-full h-full">
            <img src="{{('assets/foto_3.jpg')}}" alt="Foto 3" class="object-cover w-full h-full">
            <img src="{{('assets/foto_5.jpg')}}" alt="Foto 4" class="object-cover w-full h-full">
          </div>
        </div>
        </div>
      </div>


      <div class="sc-z container flex justify-center mb-[80px]">
        <div class="text-right w-[49%] pr-4 pt-20 slide-in-left">
          <p class="text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            Tinggal copy paste apa yang perwira crypto lakukan di market crypto. Dari mulai trading system sampai sinyal hinggal alokasi portfolio
          </p>
        </div>

        <div class="w-[2%] flex flex-col items-center justify-center slide-in-down">
          <div class=" mt-[90px] ml-[20px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
          <div class=" mt-[-110px] w-[1px] h-[120%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
        </div>

        <div class="text-left w-[49%] pl-4 pt-20">
          <div class="p-[2px] bg-gradient-to-r from-blue-900 via-blue-400 to-green-100 rounded-md slide-in-right">
          <div class="h-[140px] grid grid-cols-4 gap-0 bg-white rounded-md overflow-hidden">
            <img src="{{('assets/foto_1.jpg')}}" alt="Foto 1" class="object-cover w-full h-full">
            <img src="{{('assets/foto_2.jpg')}}" alt="Foto 2" class="object-cover w-full h-full">
            <img src="{{('assets/foto_3.jpg')}}" alt="Foto 3" class="object-cover w-full h-full">
            <img src="{{('assets/foto_5.jpg')}}" alt="Foto 4" class="object-cover w-full h-full">
          </div>
        </div>
        </div>
      </div>

      
      <div class="container mt-[120px] flex justify-center">
        <p class="text-b text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-white drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] fade-in-section">
          AKSES KE EVENT OFFLINE DAN NETWORKING DENGAN ORANG ORANG HEBAT
        </p>
      </div>

      <hr class="slide-in-down h-[1px] w-full bottom-[50px] bg-gradient-to-r from-gray-800 via-blue-500 to-gray-800 border-0 rounded-full my-6">
      
      <div class="container flex justify-center items-center flex-col mt-[80px]">
        <div
        class=" text-extrabold text-center px-5 text-[18px] lg:text-[40px] md:text-[30px] font-bold font-open-sans text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-white drop-shadow-[0_0_6px_rgba(0,0,0,0.4)]  fade-in-section"
        >
          Berikut PNL Perwira Crypto dari 1 Maret - 31 April
        </div>
        <div
          class="fade-in-section slider-pnl w-[600px] mt-[40px] bg-gradient-to-r from-blue-500 via-blue-400 to-white p-[3px] rounded-lg shadow-[0_0_15px_#7dd3fc]"
        >
          <!-- Isi hitam dengan gambar bergerak -->
          <div class=" w-full h-40 overflow-hidden bg-black rounded-lg relative">
            <div class="absolute animate-marquee flex min-w-full">
              <!-- Tambahkan cukup banyak gambar agar penuh -->
              <img
                src="{{('assets/foto_1.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_2.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_3.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_5.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_6.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_7.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_8.JPG')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_9.JPG')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_10.JPG')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <!-- Duplikat lagi agar tidak ada celah -->
              <img
                src="{{('assets/foto_1.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_2.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_3.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
            </div>
          </div>
        </div>
      </div>


      <div class="container mt-[80px] text-center h-[40px]">
        <img
          class="w-[50%] absolute left-0 h-[3px] mt-[25px] slide-in-left"
          src="{{('assets/images/misc/left-why.png')}}"
          alt=""
        />
        <img
          class="w-[50%] absolute right-0 h-[3px] mt-[25px] slide-in-right"
          src="{{('assets/images/misc/right-why.png')}}"
          alt=""
        />
      </div>

      <div class="container mt-[80px] text-center flex justify-center items-center flex-col">
        <h3 class="text-4xl font-bold font-open-sans fade-in-section">
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            84% Member Perwira Crypto <br> berhasil Cuan di Futures Market <br> Dalam 2 Bulan 
          </span>

          <span> - Sekarang <br> Waktunya Lo Yang Buktikan</span>
        </h3>

        <div
          class="fade-in-section cn-a mt-[40px] w-[600px] bg-gradient-to-r from-blue-500 via-blue-400 to-white p-[3px] rounded-lg shadow-[0_0_15px_#7dd3fc]"
        >
          <!-- Isi hitam dengan gambar bergerak -->
          <div class=" w-full h-40 overflow-hidden bg-black rounded-lg relative">
            <div class="absolute animate-marquee flex min-w-full">
              <!-- Tambahkan cukup banyak gambar agar penuh -->
              <img
                src="{{('assets/foto_1.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_2.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_3.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_5.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_6.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_7.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_8.JPG')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_9.JPG')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_10.JPG')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <!-- Duplikat lagi agar tidak ada celah -->
              <img
                src="{{('assets/foto_1.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_2.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
              <img
                src="{{('assets/foto_3.jpg')}}"
                class="h-40 w-auto object-cover mx-2"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="container mt-[120px] text-center">
        <img
          class="w-[50%] absolute left-0 h-[3px] mt-[25px] slide-in-right"
          src="{{('assets/images/misc/left-why.png')}}"
          alt=""
        />
        <img
          class="w-[50%] absolute right-0 h-[3px] mt-[25px] slide-in-left"
          src="{{('assets/images/misc/right-why.png')}}"
          alt=""
        />
        <h6
          class="fade-in-section tracking-widest font-open-sans font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)]"
        >
          EDUKASI
        </h6>
      </div>

      <div class="container mt-[80px]">
        <div class="flex justify-between relative">
          <div class="aj-a flex flex-row justify-start items-center slide-in-left">
            <img class="w-[159px]" src="{{('assets/images/wolf-principles.png')}}" alt="">
            <span class="ml-[20px] text-4xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)]">
              WOLF<br class="hide-sm">
              PRINCIPLES<br class="hide-sm">
              BOOK
            </span>
          </div>
          <div class="slide-in-right">
            <div class=" sign-a h-[1px] w-[250px] mt-[100px] bg-gradient-to-r from-blue-900 to-purple-700"></div>
            <div class="mt-[-10px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
            <div class="absolute mt-[-10px] right-0 w-[1px] h-[300%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
          </div>
        </div>

        <div class="mt-[20px] font-open-sans w-[90%] fade-in-section">
          <p>Ada 3 Versi:</p>
          <p>-Wolf Principles: Kitab Utama Cara Menjadi Serigala Di Market</p>
          <p>-Wolf Principles Rules: Daftar Aturan Permainan Yang Harus Lo Patuhi Sebagai Seorang Traders</p>
          <p>-Wolf Principles Technical Analysis</p>
          <br>
          <p>99% traders gagal, hanya ada 1% traders yang berhasil disebut dengan serigala. Wolf Principles adalah kitab utama yang paling penting, ilmu sejati untuk menjadi serigala di market. Ini adalah ilmu yang dikuasai oleh para serigala khususnya smart money. Kita bawakan pertama kali di Indonesia, tidak akan kalian temukan di indo manapun.</p>
        </div>
      </div>

      <div class="container overflow-y-hidden pb-[60px]">
        <div class="flex justify-between relative">
          <div class="aj-a mt-[60px] flex flex-row justify-start items-center slide-in-left">
            <img class="w-[159px]" src="{{('assets/images/snd.pn')}}g" alt="">
            <span class="ml-[20px] text-2xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)]">
              HOW I MIRROR <br class="hide-sm">
              SMART MONEY WITH <br class="hide-sm">
              SUPPLY & DEMAND
            </span>
          </div>
          <div class="slide-in-right">
            <div class="sign-a h-[1px] w-[250px] mt-[120px] bg-gradient-to-r from-blue-900 to-purple-700"></div>
            <div class="mt-[-10px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
            <div class="absolute mt-[-10px] right-0 w-[1px] h-[200%] bg-gradient-to-b from-blue-900 to-purple-700"></div>
          </div>
        </div>

        <div class="mt-[20px] font-open-sans w-[90%] fade-in-section">
          <p>Gua tidak mulai melakukan trading yang profitable sampai gua meniru/menyalin cara hedge fund dalam supply and demand.</p>
          <br>
          <p>Sekarang gue punya kemampuan untuk membaca supply & demand dengan benar dengan melacak jejak institusi terbesar di dunia dan trading searah dengan mereka, bukan melawan mereka.</p>
        </div>
      </div>

      <div class="container hide-sm slide-in-right">
        <div class="flex justify-end">
          <div class="ML-[50%] h-[1px] w-[39%] bg-gradient-to-r from-blue-900 to-purple-700"></div>
        </div>
      </div>

      <div class="container flex justify-center list-a">
        <div class="text-left w-[60%] pr-4 pt-6 aj-b">
          <div class="flex aj-a slide-in-left">
            <img class="w-[200px]" src="{{('assets/images/howtowin.png')}}" alt="">
            <span 
            class="ml-[20px] text-2xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)]">
              HOW TO WIN ON <br> CRYPTO FUTURES <br> TRADING
            </span>
          </div>
          <p class="font-open-sans mt-[20px] fade-in-section">
            Dirancang khusus buat lo yang pengen naik level dari pemula / traders biasa hingga jadi predator di market. Kalian akan belajar mindset, strategi, dan manajemen risiko serigala. 
          </p>
        </div>

        <div class="w-[2%] flex flex-col items-center justify-center slide-in-up">
          <div class=" mt-[40px] ml-[20px] transform -translate-x-1/2 rotate-45 w-5 h-5 bg-[radial-gradient(circle_at_center,_#a78bfa_0%,_#1e3a8a_100%)]"></div>
          <div class=" sign-b mt-[-160px] w-[1px] h-[160px] bg-gradient-to-b from-blue-900 to-purple-700"></div>
        </div>

        <div class="slide-in-right card-c aj-a flex flex-col justify-center items-center w-[38%] pl-4 pt-6">
          <img class="w-[200px]" src="{{('assets/images/howsmart.png')}}" alt="">
          <p class="mt-[20px] font-semibold text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed">
            HOW TO OUTSMART <br class="hide-sm">
            99% OF TRADERS <br class="hide-sm">
            WITH PSYCHOLOGY
          </p>
        </div>
      </div>

      <div class="container text-center mt-[40px] fade-in-section">
        <span class="text-3xl font-open-sans">
          Dan Masih Banyak Lagi
        </span>
      </div>


      <div class="container mt-[120px] text-center">
        <img
          class="w-[50%] absolute left-0 h-[3px] mt-[25px] slide-in-left"
          src="{{('assets/images/misc/left-why.png')}}"
          alt=""
        />
        <img
          class="w-[50%] absolute right-0 h-[3px] mt-[25px] slide-in-right"
          src="{{('assets/images/misc/right-why.png')}}"
          alt=""
        />
        <h6
          class="fade-in-section tracking-widest font-open-sans font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] "
        >
          INVESTMENT VALUE
        </h6>
      </div>

      <!-- investmentvalue -->
      <div class="container w-[100%] mt-[40px]">
        <div class="flex justify-around flex-row card-list">
          <div class="slide-in-left overflow-hidden card-holder w-[400px] bg-gradient-to-r from-[#7a9ac5] via-[#052146] to-[#afd2ff] p-[1px] shadow-[0_0_15px_#367cff70]">
            <div class="card w-[100%] p-[20px] flex justify-center flex-col items-center bg-[#021028]">
              <div class="card-header text-center font-open-sans">
                <h4 class="text-3xl font-thin text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] ">
                  WOLF PACK
                </h4>
                <p class="mb-[20px] text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] ">
                  (1 TAHUN)
                </p>
                <hr class="h-[1px] w-full bottom-[50px] bg-gradient-to-r from-gray-800 via-blue-500 to-gray-800 border-0 rounded-full my-6">
              </div>
              <div class="card-body font-open-sans mt-[20px]">
                <ul>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>COPY TRADING:</span> Sinyal dan Trade idea dari Perwira Crypto & Wolf Of Trade
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>MARKET & COIN OUTLOOK</span>
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>KRYPTON ULTIMATE CRYPTO TRADING MASTERY COURSE </span>(MODUL & EBOOK)
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>PERWIRA CRYPTO TRADING SYSTEM & SECRET FRAMEWORK</span>
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>LIVE DISCORD </span>LIVE TRADING & TANYA JAWAB
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>QUANTUM CIPHER VIDEO ANALYSIS: </span>LAPORAN VIDEO ANALISA TRADE
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>THE WOLF OF THE REALMS: </span>KOMUNITAS PARA SERIGALA
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>KESEMPATAN MENJADI TRADERS WOLF OF TRADE</span> <br>
                      DI PERWIRA CRYPTO - KALAU TERBUKTI JAGO
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>PERWIRA CRYPTO CORE TRADING STRATEGY (TECHNICAL ANALYSIS)</span> <br>
                      -PSYCHOANALYTICS <br>
                      -MARKET MECHANIC <br>
                      -OFFENSIVE AND DEFENSIVE TRADING 
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check.png')}}">
                    <p>
                      <span>CRYPTO COIN / TOKEN RESEARCH</span>
                    </p>
                  </li>

                  <li class="reject">
                    <img class="list-type" src="{{('assets/images/misc/reject.png')}}">
                    <p>
                      <span>KRYPTONITE</span> COMPOUNDING <br>
                      AND PORTFOLIO ALLOCATION FROM PERWIRA CRYPTO TRADING TO P21 CAPITAL INVESTING
                    </p>
                  </li>
                  <li class="reject">
                    <img class="list-type" src="{{('assets/images/misc/reject.png')}}">
                    <p>
                      <span>KRYPTON ULTIMATE CRYPTO TRADING MENTORSHIP</span> BELAJAR LANGSUNG DENGAN FOUNDERS DI KANTOR
                    </p>
                  </li>
                  <li class="reject">
                    <img class="list-type" src="{{('assets/images/misc/reject.png')}}">
                    <p>
                      <span>ELITE GUIDANCE</span> SESI MENTORING PER QUARTAL
                    </p>
                  </li>
                  <li class="reject">
                    <img class="list-type" src="{{('assets/images/misc/reject.png')}}">
                    <p>
                      <span>LIFETIME EVENT PRIORITY ACCESS</span>
                    </p>
                  </li>
                  <li class="reject">
                    <img class="list-type" src="{{('assets/images/misc/reject.png')}}">
                    <p>
                      <span>PERWIRA CRYPTO EXCLUSIVE TSHIRT</span>
                    </p>
                  </li>
                </ul>
              </div>
              <div class="card-footer mb-[20px] flex justify-center items-center font-open-sans text-xl">
                <a href="/login">
  <button class="font-bold min-w-[68px] bg-gradient-to-r from-[#528fff] to-[#07368e] px-[20px] py-[10px] rounded-[5px]">
    DAPATKAN AKSES
  </button>
</a>
              </div>
            </div>
          </div>
          <div class="slide-in-right overflow-hidden card-holder w-[400px] bg-gradient-to-r from-[#f5a3ff] via-[#3b0546] to-[#a01dbf] p-[1px] shadow-[0_0_15px_#e366ff70]">
            <div class="card w-[100%] p-[20px] flex justify-center flex-col items-center bg-[#021028] exclusive">
              <div class="card-header text-center font-open-sans">
                <h4 class="text-3xl font-thin text-transparent bg-clip-text bg-gradient-to-r from-[#f5a3ff] to-[#a01dbf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] ">
                  ETERNAL
                </h4>
                <p class="mb-[20px] text-transparent bg-clip-text bg-gradient-to-r from-[#f5a3ff] to-[#a01dbf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] ">
                  (1 TAHUN)
                </p>
                <hr class="h-[1px] w-full bottom-[50px] bg-gradient-to-r from-gray-800 via-[#e366ff] to-gray-800 border-0 rounded-full my-6">
              </div>
              <div class="card-body font-open-sans mt-[20px]">
                <ul>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>COPY TRADING:</span> Sinyal dan Trade idea dari Perwira Crypto & Wolf Of Trade
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>MARKET & COIN OUTLOOK</span>
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="a{{('ssets/images/misc/check-ex.png')}}">
                    <p>
                      <span>KRYPTON ULTIMATE CRYPTO TRADING MASTERY COURSE </span>(MODUL & EBOOK)
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>PERWIRA CRYPTO TRADING SYSTEM & SECRET FRAMEWORK</span>
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>LIVE DISCORD </span>LIVE TRADING & TANYA JAWAB
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>QUANTUM CIPHER VIDEO ANALYSIS: </span>LAPORAN VIDEO ANALISA TRADE
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>THE WOLF OF THE REALMS: </span>KOMUNITAS PARA SERIGALA
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>KESEMPATAN MENJADI TRADERS WOLF OF TRADE</span> <br>
                      DI PERWIRA CRYPTO - KALAU TERBUKTI JAGO
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>PERWIRA CRYPTO CORE TRADING STRATEGY (TECHNICAL ANALYSIS)</span> <br>
                      -PSYCHOANALYTICS <br>
                      -MARKET MECHANIC <br>
                      -OFFENSIVE AND DEFENSIVE TRADING 
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>CRYPTO COIN / TOKEN RESEARCH</span>
                    </p>
                  </li>

                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>KRYPTONITE</span> COMPOUNDING <br>
                      AND PORTFOLIO ALLOCATION FROM PERWIRA CRYPTO TRADING TO P21 CAPITAL INVESTING
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>KRYPTON ULTIMATE CRYPTO TRADING MENTORSHIP</span> BELAJAR LANGSUNG DENGAN FOUNDERS DI KANTOR
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>ELITE GUIDANCE</span> SESI MENTORING PER QUARTAL
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>LIFETIME EVENT PRIORITY ACCESS</span>
                    </p>
                  </li>
                  <li>
                    <img class="list-type" src="{{('assets/images/misc/check-ex.png')}}">
                    <p>
                      <span>PERWIRA CRYPTO EXCLUSIVE TSHIRT</span>
                    </p>
                  </li>
                </ul>
              </div>
              <div class="card-footer mb-[20px] flex justify-center items-center font-open-sans text-xl">
                <button class="font-bold min-w-[68px] bg-gradient-to-r from-[#da52ff] to-[#7a078e] px-[20px] py-[10px] rounded-[5px]">
                  DAPATKAN AKSES
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="container mt-[80px] flex flex-col justify-center items-center">
        <h5 class="fade-in-section text-center text-3xl text-transparent bg-clip-text bg-gradient-to-r from-[#a3d4ff] to-[#1d63bf] drop-shadow-[0_0_6px_rgba(15,91,203,0.4)] leading-relaxed drop-shadow-[0_0_6px_rgba(0,0,0,0.4)] ">
          FREQUENTLY ASKED QUESTIONS
        </h5>

        <div class="slide-in-left mt-[20px] w-[100%] p-[28px] rounded-[10px] max-w-[920px] question-box grid grid-cols-12 bg-[#90909020]">
          <div class="text-box col-span-11 font-open-sans">
            <div class="question text-xl">
              Apakah trading crypto pasti akan mendapatkan keuntungan?
            </div>
            <div class="answer mt-[20px]">
              -
            </div>
          </div>
          <div class="box-action flex justify-center flex-col items-center w-[100%] h-[100%] flex justify-center items-center">
            <img class="duration-500" src="{{('assets/images/misc/clip-v.png')}}">
          </div>
        </div>

        <div class="slide-in-right mt-[20px] w-[100%] p-[28px] rounded-[10px] max-w-[920px] question-box grid grid-cols-12 bg-[#90909020]">
          <div class="text-box col-span-11 font-open-sans">
            <div class="question text-xl">
              Berapa modal yang besar untuk trading crypto?
            </div>
            <div class="answer mt-[20px]">
              -
            </div>
          </div>
          <div class="box-action flex justify-center flex-col items-center w-[100%] h-[100%] flex justify-center items-center">
            <img class="duration-500" src="{{('assets/images/misc/clip-v.png')}}">
          </div>
        </div>

        <div class="slide-in-left mt-[20px] w-[100%] p-[28px] rounded-[10px] max-w-[920px] question-box grid grid-cols-12 bg-[#90909020]">
          <div class="text-box col-span-11 font-open-sans">
            <div class="question text-xl">
              Saya masih awam trading crypto apakah bisa join perwira crypto?
            </div>
            <div class="answer mt-[20px]">
              -
            </div>
          </div>
          <div class="box-action flex justify-center flex-col items-center w-[100%] h-[100%] flex justify-center items-center">
            <img class="duration-500" src="{{('assets/images/misc/clip-v.png')}}">
          </div>
        </div>

        <div class="slide-in-right mt-[20px] w-[100%] p-[28px] rounded-[10px] max-w-[920px] question-box grid grid-cols-12 bg-[#90909020]">
          <div class="text-box col-span-11 font-open-sans">
            <div class="question text-xl">
              Apakah bisa menjadi kaya dari trading crypto?
            </div>
            <div class="answer mt-[20px]">
              -
            </div>
          </div>
          <div class="box-action flex justify-center flex-col items-center w-[100%] h-[100%] flex justify-center items-center">
            <img class="duration-500" src="{{('assets/images/misc/clip-v.png')}}">
          </div>
        </div>
      </div>



    </main>

    <footer class="w-[100%]">
      <hr class="h-[1px] w-full bottom-[50px] bg-gradient-to-r from-gray-800 via-blue-500 to-gray-800 border-0 rounded-full my-6">
      
      <div class="flex justify-center flex-col items-center">
        <div class="logo flex flex-row items-center">
          <img
            src="{{('assets/images/icon-50%.svg')}}"
            alt="Perwira Crypto"
            class="w-[81px] h-[104px] inline-block"
          />
          <span class="text-center font-open-sans font-bold text-[11px]"
            >PERWIRA <br />
            CRYPTO</span
          >
        </div>

        <span class="mt-[20px] text-[13px] font-open-sans font-light">+6287717392283 | P21capitalofficial@gmail.com</span>
        <span class="mb-[20px] text-[13px] font-open-sans font-light">Copyright © 2025 All rights reserved</span>
      </div>
    </footer>

  </body>
  <script src="{{('assets/js/animation.js')}}"></script>
  <script src="{{('assets/js/question-box.js')}}"></script>
</html>
