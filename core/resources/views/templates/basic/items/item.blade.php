     <article class="card jss--card jss--card-{{ $type }}"
         style="background: #ffffff !important; border: 1px solid #dadbdd !important; border-radius: 4px !important; box-shadow: none !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; height: 100% !important; font-family: Macan, 'Helvetica Neue', Helvetica, Arial, sans-serif !important; position: relative !important; transition: all 0.2s ease-in-out;">
         @php
             $avgRatingNumeric = $product->total_review > 0 ? $product->total_rating / $product->total_review : 0;

             if ($avgRatingNumeric >= 4.0) {
                 $badgeText = 'TOP RATED';
                 $badgeColor = '#446ee7';
                 $badgeBg = '#f4f5f7';
             } elseif ($avgRatingNumeric >= 3.0) {
                 $badgeText = 'LEVEL 2';
                 $badgeColor = '#1dbf73';
                 $badgeBg = '#eefbf4';
             } elseif ($avgRatingNumeric >= 2.0) {
                 $badgeText = 'LEVEL 1';
                 $badgeColor = '#ff7a00';
                 $badgeBg = '#fff8f2';
             } else {
                 $badgeText = 'NEW SELLER';
                 $badgeColor = '#74767e';
                 $badgeBg = '#f5f5f5';
             }

             $cardAvgRating = $product->total_review > 0 ? number_format($avgRatingNumeric, 1) : '0.0';
             $totalReviews = $product->total_review > 0 ? $product->total_review : 0;
         @endphp
         <div
             style="position: relative !important; display: block !important; width: 100% !important; aspect-ratio: 16 / 10 !important; overflow: hidden !important; background: #f8f9fa !important;">
             <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
                 style="display: block !important; width: 100% !important; height: 100% !important;">
                 <img src="{{ getImage(getFilePath($type) . '/' . $product->image, getFileSize($type)) }}"
                     alt="{{ $product->name }}"
                     style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
             </a>
         </div>

         <div
             style="display: flex !important; flex-direction: column !important; flex-grow: 1 !important; justify-content: space-between !important;">

             <div class="px-2 py-2">
                 <h6
                     style="font-size: 14px !important; font-weight: 400 !important; line-height: 1.4 !important; margin: 0 !important; min-height: 42px !important; overflow: hidden !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important; text-transform: capitalize !important;">
                     <a href="{{ route("$type.details", [slug($product->name), $product->id]) }}"
                         style="color: #404145 !important; text-decoration: none !important; display: block !important;"
                         onmouseover="this.style.color='#1dbf73'" onmouseout="this.style.color='#404145'">
                         {{ __($product->name) }}
                     </a>
                 </h6>
             </div>

             <div class="px-2"
                 style="display: flex !important; justify-content: space-between !important; align-items: center !important;">
                 <div>
                     <i class="ri-check-line"
                         style="font-size: 20px !important; color: #b5b6ba !important; font-weight: bold;"></i>
                 </div>
                 <div style="text-align: right !important;">
                     <span
                         style="font-weight: 700 !important; color: #1dbf73 !important; font-size: 16px !important; display: flex; align-items: center; gap: 2px;">
                         <span
                             style="font-size: 14px; font-weight: 600;">&#2547;</span>{{ number_format($product->price) }}
                     </span>
                 </div>
             </div>

             <hr style="border: 0; border-top: 1px solid #e4e5e7; margin:0 !important;">

             <div class="px-2 py-2"
                 style="display: flex !important; align-items: center !important; justify-content: space-between !important;">
                 <div style="display: flex !important; flex-direction: column !important; gap: 4px !important;">
                     <div onclick="window.open('{{ route('public.profile', ['username' => $product->user->username, 'contact' => 'true']) }}', '_blank')"
                         style="display: flex !important; align-items: center !important; gap: 6px !important; cursor: pointer !important;">
                         <span
                             style="width: 8px; height: 8px; background-color: #b5b6ba; border-radius: 50%; display: inline-block;"></span>
                         <span
                             style="font-size: 13px !important; text-transform: capitalize; font-weight: 600 !important; color: #404145 !important; max-width: 90px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;"
                             title="{{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}">
                             {{ $product->user ? $product->user->username : $product->username ?? 'babsmart_' }}
                         </span>
                     </div>

                     <div
                         style="display: inline-flex; align-items: center; background: {{ $badgeBg }}; border: 1px solid {{ $badgeColor }}40; padding: 2px 6px; border-radius: 3px; width: fit-content;">
                         <span
                             style="color: {{ $badgeColor }}; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                             {{ $badgeText }}
                         </span>
                     </div>
                 </div>

                 <div
                     style="display: flex !important; align-items: center !important; gap: 3px !important; font-size: 13px !important; font-weight: 700 !important;">
                     <span style="color: #ffb33e !important; font-size: 14px !important;">★</span>
                     <span style="color: #ff7a00 !important;">{{ $cardAvgRating }}</span>
                     <span style="color: #74767e !important; font-weight: 400 !important;">({{ $totalReviews }})</span>
                 </div>

             </div>

         </div>
     </article>
