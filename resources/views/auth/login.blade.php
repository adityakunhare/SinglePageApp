@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6 ">
        <svg class="fill-current text-white w-16" viewBox="0 0 94.666664 57.333332">
            <path
                d="M 27.999999,55.632984 C 27.999999,54.329795 24.729937,54.053684 14,54.450876 1.3821009,54.917955 0,54.739836 0,52.646623 0,50.546297 1.3711154,50.380565 14.333333,50.914095 L 28.666666,51.50406 33.079502,33.220082 C 37.955046,13.01893 37.65836,13.387785 49.060605,13.35154 c 4.389323,-0.01395 6.528516,0.783037 9.157104,3.411625 3.041193,3.041193 3.361928,4.248663 2.830563,10.656232 l -0.59927,7.226401 6.950501,-10.989565 C 79.519547,4.4930084 81.020894,2.6666666 84.653992,2.6666666 c 1.840303,0 3.346006,0.4672915 3.346006,1.0384254 0,0.5711342 1.190615,9.421134 2.645811,19.666666 3.336415,23.49053 3.344371,24.628241 0.172247,24.628241 -1.958881,0 -2.714306,-1.327237 -3.41503,-6 l -0.899756,-6 H 76.223786 65.944302 l -3.277637,6 c -2.413391,4.41792 -4.085049,6 -6.339725,6 -3.017854,0 -3.030251,-0.0626 -0.858207,-4.333333 l 2.203883,-4.333334 -3.169643,2.911184 c -4.047377,3.717347 -9.449998,5.755483 -15.256441,5.755483 -2.774384,0 -4.580325,0.657036 -4.581029,1.666667 -9.04e-4,1.295297 6.683745,1.581545 29.999999,1.284651 26.684125,-0.339778 30.001162,-0.147801 30.001162,1.736346 0,1.885876 -3.365757,2.074132 -30.66798,1.715349 -23.860961,-0.313561 -30.667689,-0.03308 -30.666666,1.263653 7.22e-4,0.916667 -1.198686,1.666667 -2.665352,1.666667 -1.466667,0 -2.666667,-0.765157 -2.666667,-1.700348 z m 18.553592,-13.96839 c 2.504474,-1.282194 5.654474,-4.4219 6.999999,-6.977125 5.112786,-9.709463 1.726056,-17.967027 -7.019318,-17.114583 -4.334632,0.422512 -4.414617,0.556379 -7.425168,12.427113 -1.673834,6.6 -3.058133,12.45 -3.07622,13 -0.05915,1.798627 5.868809,1.046184 10.520707,-1.335405 z M 85.503306,31.385581 C 86.37809,30.510795 83.789183,9.3333331 82.807459,9.3333331 c -0.911001,0 -13.474128,20.2594519 -13.474128,21.7285409 0,1.022105 15.167929,1.325751 16.169975,0.323707 z M 2.8057102,46.780815 c -1.0643768,-0.673959 -1.4952366,-2.1314 -1.0065677,-3.404851 0.641761,-1.672402 1.6026186,-1.954757 3.8609563,-1.134566 9.1397952,3.31942 19.6732342,-0.438947 19.6732342,-7.019477 0,-3.629915 -2.271736,-6.079956 -9.300224,-10.030188 C 6.8838537,20.049564 6.2055201,10.021686 14.622148,4.3333332 20.866793,0.11290788 35.999999,0.40325147 35.999999,4.7434858 c 0,2.7585672 -1.907565,3.2880728 -6.795366,1.8862702 -6.199483,-1.7779884 -12.943897,0.5338118 -14.015695,4.804196 -1.183261,4.714489 0.01646,6.70725 6.414033,10.653831 7.439683,4.589446 9.063695,6.785216 9.063695,12.254711 0,5.8977 -1.870135,9.177122 -6.639979,11.643705 -4.231765,2.188331 -18.1942106,2.711152 -21.2209768,0.794616 z"
                id="path14" inkscape:connector-curvature="0" />
        </svg>

        <h1 class="text-white text-3xl pt-8 ">Welcome Back</h1>
        <h2 class="text-blue-300">Enter your credentials below</h2>
        <form method="POST" action="{{ route('login') }}" class="pt-8 ">
            @csrf

            <div class="relative">
                <label for="email" class="uppercase text-blue-500 text-xs font-bold  absolute pl-3 pt-2 ">E-mail</label>

                <div class="">
                    <input id="email" type="email"
                        class="pt-8 w-full bg-blue-800 text-gray-100 outline-none focus:bg-blue-700 rounded p-3"
                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                        placeholder="your@email.com">

                    @error('email')
                    <span class="text-red-500 text-sm" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="relative pt-3">
                <label for="password"
                    class="uppercase text-blue-500 text-xs font-bold  absolute pl-3 pt-2">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                        class="pt-8 w-full bg-blue-800 text-gray-100 outline-none focus:bg-blue-700 rounded p-3"
                        name="password" autocomplete="current-password" placeholder="password">

                    @error('password')
                    <span class="text-red-500 text-sm" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="pt-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                <label class="text-white" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <div class="pt-8">
                <button type="submit"
                    class="uppercase bg-gray-400 w-full py-2 px-3 rounded text-left text-blue-800 font-bold">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="flex justify-between text-sm font-bold pt-8 text-white">
                <a class="" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
                <a class="" href="{{ route('register') }}">
                    SignUp
                </a>
            </div>
        </form>
    </div>
</div>
@endsection