<!doctype html>
<html lang="zh_CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>理想国</title>
</head>
<body>
<div class="mxa sticky top-0">
    <div
        class="flex justify-between items-center pt-3 pb-14 px-5 md:px-5 lg:px-36 bg-gradient-to-b from-base-300 to-transparent">
        <a href="">
            <h1 class="text-lg font-bold uppercase m-2">理想国</h1>
        </a>
        <div class="flex flex-row items-center gap-2">
            <div class=" flex-row gap-1 hidden md:flex lg:flex">

            </div>

            <button class=" btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                          d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                          clip-rule="evenodd" />
                </svg>

            </button>

        </div>
    </div>
</div>
<div class="px-5 md:px-5 lg:px-36">
    <div class="flex flex-col items-center gap-5">
        <div class="rounded-full overflow-hidden w-20 h-20">
            <img class="object-cover mx-auto transition ease-in-out hover:scale-110"
                 src="data:image/jpeg;base64,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"
                 alt="">
        </div>
        <div class="flex flex-col items-center gap-2 max-w-sm">
            <h1 class="text-xl font-bold">卡密验证</h1>
            <p class="text-base">已然遥远的理想乡，那是我们的理想国</p>
            <div class="flex flex-row gap-2">
                <a href="/admin" class="mt-4">登录</a>
            </div>
        </div>

    </div>
    <div class="grid grid-cols-1 pt-10 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-10">
        <div
            class="flex flex-col bg-base-200/50 p-5 rounded-lg gap-2 transition ease-in-out hover:translate-y-2 md:hover:skew-y-2">
            <h2 class="text-sm font-bold">安全</h2>
            <p class="uppercase text-xs">比特币同款签名校验</p>
        </div>
        <div
            class="flex flex-col bg-base-200/50 p-5 rounded-lg gap-2 transition ease-in-out hover:translate-y-2 md:hover:skew-y-2">
            <h2 class="text-sm font-bold">高效</h2>
            <p class="uppercase text-xs">新一代防破解 , 最先进的加密校验算法 , 超强防破解</p>
        </div>
        <div
            class="flex flex-col bg-base-200/50 p-5 rounded-lg gap-2 transition ease-in-out hover:translate-y-2 md:hover:skew-y-2">
            <h2 class="text-sm font-bold">成本</h2>
            <p class="uppercase text-xs">无需购买服务器、域名、空间等 ,</p>
        </div>
        <div
            class="flex flex-col bg-base-200/50 p-5 rounded-lg gap-2 transition ease-in-out hover:translate-y-2 md:hover:skew-y-3">
            <h2 class="text-sm font-bold">专业</h2>
            <p class="uppercase text-xs">我们的团队拥有丰富的软件行业经验 , 我们承诺提供业界内最为迅速的问题响应和最为敏捷的交流方式 , 提供贴心的管家式服务 , 不用担心再也找不到人的问题</p>
        </div>

    </div>
    <div
        class="flex flex-col gap-5 md:gap-10 lg:gap-10 justify-start items-start md:items-center md:flex-row lg:flex-row py-5">
        <div class="flex flex-col flex-none gap-1">
            <h2 class="text-3xl font-black">理想国</h2>
            <div class="flex gap-2 flex-row md:flex-col">
                <p class="text-xs">全新卡密验证</p>
            </div>
        </div>
        <div class="flex flex-col">
            <p class="text-sm  leading-loose">
                理想国网络验证系统是一套专为软件开发者设计的防破解授权计费系统<br>
                系统采用AES高级加密 + MD5双向校验算法的多重安全防护 , 超强防破解 , 更好的保护您的软件作品<br>
            </p>
        </div>
    </div>
    <div class="divider"></div>
</div>

</body>
</html>
