<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- QR Code & Barcode Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- PDF Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        @media print {
            @page {
                size: A4 portrait;
                margin: 0mm !important;
            }
            body { 
                background: white !important; 
                padding: 0 !important; 
                margin: 0 !important; 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            .invoice-card { 
                box-shadow: none !important; 
                margin: 0 !important; 
                border-radius: 0 !important;
                width: 210mm !important;
                height: 297mm !important;
                max-width: 100% !important;
                position: relative !important;
                overflow: hidden !important;
                background: white !important;
                display: flex !important;
                flex-direction: column !important;
            }
            
            /* Vertical Compression for A4 */
            .p-8, .p-10, .p-14 { padding: 6mm 8mm !important; }
            .md\:p-10, .md\:p-14 { padding: 6mm 8mm !important; }
            .pb-8, .pb-14 { padding-bottom: 5mm !important; }
            .mt-14 { margin-top: 5mm !important; }
            .mb-14 { margin-bottom: 5mm !important; }
            .gap-10 { gap: 6mm !important; }
            .gap-16 { gap: 8mm !important; }
            
            /* Text & Font Scaling */
            h1 { font-size: 18pt !important; line-height: 1 !important; }
            h2 { font-size: 20pt !important; line-height: 0.9 !important; letter-spacing: -1px !important; }
            .text-5xl { font-size: 24pt !important; }
            .text-4xl { font-size: 20pt !important; }
            .text-3xl { font-size: 16pt !important; }
            .text-2xl { font-size: 12pt !important; }
            .text-xl { font-size: 11pt !important; }
            .text-sm { font-size: 8.5pt !important; }
            .text-xs { font-size: 7.5pt !important; }
            .text-\[10px\] { font-size: 7pt !important; }
            .tracking-widest { letter-spacing: 0.05em !important; }
            
            /* Watermark & Badges */
            .verification-stamp { font-size: 60pt !important; opacity: 0.03 !important; }
            .glass-badge { border: 1px solid rgba(0,0,0,0.05) !important; }
            
            /* Force Backgrounds & Colors */
            .bg-[#1B2559] { background-color: #1B2559 !important; -webkit-print-color-adjust: exact; }
            .bg-[#F4F7FE] { background-color: #F4F7FE !important; -webkit-print-color-adjust: exact; }
            .bg-[#FBFDFF] { background-color: #FBFDFF !important; -webkit-print-color-adjust: exact; }
            .premium-bg { background: #4318FF !important; -webkit-print-color-adjust: exact; } /* Fallback to solid for print stability */
            .totals-box { background-color: #1B2559 !important; border-radius: 15px !important; color: white !important; padding: 5mm !important; margin-top: 0 !important; }
            .bg-white { background-color: white !important; }
            
            /* Table & Content Optimization */
            table { width: 100% !important; table-layout: fixed; }
            th { background-color: #F4F7FE !important; padding: 2mm 3mm !important; }
            td { padding: 2mm 3mm !important; border-bottom: 0.2mm solid #f0f0f0 !important; }
            .shrink-0 { flex-shrink: 1 !important; } /* Allow images to shrink if needed */
            
            /* Header & Footer Tweak */
            #qrcode, #barcode { transform: scale(0.75); transform-origin: top right; }
            .py-6 { padding-top: 2mm !important; padding-bottom: 2mm !important; }
            
            /* Layout Grid/Flex Fixes */
            .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)) !important; }
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
            
            /* Fix Order Number Wrapping */
            h2.break-all { word-break: break-word !important; line-height: 1.1 !important; }
        }

        .premium-bg { background: linear-gradient(135deg, #4318FF 0%, #1B2559 100%); }
        .glass-badge { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .invoice-card { border-radius: 40px; }
        
        #qrcode img { display: inline-block !important; }
        .verification-stamp { 
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            opacity: 0.05;
            font-size: 100px;
            font-weight: 900;
            pointer-events: none;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body class="p-4 md:p-10">
    <div class="max-w-4xl mx-auto bg-white shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] invoice-card overflow-hidden print-shadow-none relative">
        <!-- Verification Watermark -->
        <div class="verification-stamp font-outfit uppercase">Verified Authentic</div>

        <!-- Action Bar (No Print) -->
        <div class="bg-[#1B2559] px-8 py-4 no-print flex justify-between items-center">
            @auth
                <a href="{{ route('account.orders') }}" class="text-[#A3AED0] hover:text-white transition-colors flex items-center font-medium uppercase text-[10px] tracking-widest">
                    <i class="fas fa-arrow-left mr-2"></i> back to history
                </a>
            @else
                <a href="{{ route('home') }}" class="text-[#A3AED0] hover:text-white transition-colors flex items-center font-medium uppercase text-[10px] tracking-widest">
                    <i class="fas fa-home mr-2"></i> back to home
                </a>
            @endauth
            <div class="flex gap-2">
                <button onclick="downloadPDF()" class="bg-white/10 hover:bg-white/20 text-white px-4 md:px-6 py-2.5 rounded-2xl font-bold flex items-center transition-all border border-white/10 text-xs md:text-sm">
                    <i class="fas fa-download mr-2"></i> Download
                </button>
                <button onclick="window.print()" class="bg-[#4318FF] hover:bg-[#3311CC] text-white px-4 md:px-6 py-2.5 rounded-2xl font-bold flex items-center transition-all shadow-lg shadow-[#4318FF]/20 text-xs md:text-sm">
                    <i class="fas fa-print mr-2"></i> Print Pro
                </button>
            </div>
        </div>

        <!-- Header -->
        <div class="p-8 md:p-14 border-b border-gray-100 flex-row-print">
            <div class="flex flex-col md:flex-row justify-between gap-8 md:gap-10 col-print w-full">
                <div class="space-y-4 md:space-y-6 col-print w-[60%]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl premium-bg flex items-center justify-center text-white text-lg md:text-xl font-bold font-outfit">S</div>
                        <h1 class="text-2xl md:text-3xl font-black text-[#1B2559] tracking-tighter uppercase font-outfit">{{ config('app.name') }}</h1>
                    </div>
                    <div class="text-[#707EAE] space-y-0.5 md:space-y-1 font-medium italic">
                        <p class="text-xs md:text-sm max-w-[250px] leading-relaxed">123 Shoe Street, Fashion City<br>Dhaka, Bangladesh</p>
                        <p class="text-xs md:text-sm">support@shoehub.com</p>
                        <p class="text-xs md:text-sm font-bold text-[#4318FF] mt-1 md:mt-2">+880 1234 567890</p>
                    </div>
                </div>
                
                <div class="md:text-right flex flex-col items-start md:items-end justify-between col-print w-[40%]">
                    <div class="md:text-right">
                        <span class="inline-block px-3 py-1 md:px-4 md:py-1.5 rounded-full bg-[#F4F7FE] text-[#4318FF] text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] mb-3 md:mb-4">Official Receipt</span>
                        <h2 class="text-4xl md:text-5xl font-black text-[#1B2559] font-outfit tracking-tighter mb-1 md:mb-2 text-wrap break-all">#{{ $order->order_number }}</h2>
                        <div class="flex md:justify-end items-center gap-3 md:gap-4 text-[#A3AED0] font-bold text-[10px] uppercase tracking-widest">
                            <span>Issued: {{ $order->created_at->format('d M, Y') }}</span>
                            <span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-gray-200"></span>
                            <span class="text-[#4318FF]">ID: {{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill To / ship To -->
        <div class="p-8 md:p-14 grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 bg-[#FBFDFF] flex-row-print">
            <div class="space-y-4 md:space-y-6 col-print w-1/2">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#4318FF]/10 flex items-center justify-center text-[#4318FF] text-xs md:text-sm">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="text-[9px] md:text-xs font-black text-[#A3AED0] uppercase tracking-[0.25em]">Customer Intelligence</h3>
                </div>
                <div class="pl-10 md:pl-12 space-y-3 md:space-y-4">
                    <div>
                        <p class="text-xl md:text-2xl font-black text-[#1B2559] font-outfit leading-tight mb-0.5 md:mb-1">{{ $order->customer_name }}</p>
                        <p class="text-[#707EAE] font-semibold flex items-center gap-2 text-xs md:text-sm">
                             <i class="fas fa-phone-alt text-[9px]"></i> {{ $order->customer_phone }}
                        </p>
                    </div>
                    <div class="text-[#707EAE] text-xs md:text-sm leading-relaxed font-medium">
                        <p>{{ $order->shipping_address_line1 }}</p>
                        @if($order->shipping_address_line2) <p>{{ $order->shipping_address_line2 }}</p> @endif
                        <p class="font-bold text-[#1B2559] mt-0.5 md:mt-1">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 md:space-y-6 text-left md:text-right col-print w-1/2">
                <div class="flex items-center md:justify-end gap-3 md:gap-4">
                    <h3 class="text-[9px] md:text-xs font-black text-[#A3AED0] uppercase tracking-[0.25em]">Transactional Data</h3>
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#05CD99]/10 flex items-center justify-center text-[#05CD99] text-xs md:text-sm">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
                <div class="md:pr-12 space-y-4 md:space-y-6 flex flex-col md:items-end">
                    <div class="flex flex-col md:items-end">
                        <p class="text-[9px] px-10 md:px-0 md:text-[11px] font-black text-[#A3AED0] uppercase tracking-widest mb-0.5 md:mb-1">Settlement Via</p>
                        <p class="text-lg md:text-xl font-bold text-[#1B2559] uppercase px-10 md:px-0">{{ strtoupper($order->payment_method) }}</p>
                    </div>
                    
                    <div class="flex md:justify-end gap-3 px-10 md:px-0">
                        <div class="bg-white border border-gray-100 p-2 md:p-3 rounded-2xl shadow-sm text-center min-w-[100px] md:min-w-[120px]">
                            <p class="text-[8px] md:text-[9px] font-black text-[#A3AED0] uppercase tracking-widest mb-0.5 md:mb-1">Status</p>
                            <span class="inline-flex items-center px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[9px] md:text-[10px] font-black uppercase {{ $order->payment_status == 'paid' ? 'bg-[#05CD99]/10 text-[#05CD99]' : 'bg-[#EE5D50]/10 text-[#EE5D50]' }}">
                                <span class="w-1 md:w-1.5 h-1 md:h-1.5 rounded-full mr-1.5 md:mr-2 {{ $order->payment_status == 'paid' ? 'bg-[#05CD99]' : 'bg-[#EE5D50]' }}"></span>
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="px-4 md:px-14 pb-8 md:pb-14">
            <div class="rounded-[1.5rem] md:rounded-3xl border border-gray-100 overflow-x-auto bg-white shadow-sm">
                <table class="w-full text-left min-w-[500px] md:min-w-0">
                    <thead>
                        <tr class="bg-[#F4F7FE]">
                            <th class="pl-6 md:pl-8 py-3 md:py-5 text-[8px] md:text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em] w-[45%]">Item Specification</th>
                            <th class="px-2 md:px-4 py-3 md:py-5 text-[8px] md:text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em] text-center w-[15%]">Unit Price</th>
                            <th class="px-2 md:px-4 py-3 md:py-5 text-[8px] md:text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em] text-center w-[15%]">Qty</th>
                            <th class="pr-6 md:pr-8 py-3 md:py-5 text-[8px] md:text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em] text-right w-[25%]">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <tr class="group hover:bg-[#FBFDFF] transition-colors">
                                <td class="pl-6 md:pl-8 py-3 md:py-4">
                                    <div class="flex items-center gap-3 md:gap-4">
                                        <div class="w-8 h-8 md:w-12 md:h-12 rounded-lg md:rounded-xl bg-gray-50 border border-gray-100 overflow-hidden shrink-0 shadow-sm print:border-gray-200">
                                            @if($item->product && $item->product->featured_image)
                                                <img src="{{ getProductImage($item->product->featured_image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[8px] font-bold text-gray-300">HUB</div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold md:font-extrabold text-[#1B2559] text-xs md:text-base leading-tight mb-0.5">{{ $item->product_name }}</p>
                                            <div class="flex items-center gap-2 md:gap-3 text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-[#A3AED0]">
                                                <span class="text-[#4318FF]">{{ $item->product->sku ?? 'SKU-GEN' }}</span>
                                                @if($item->size)<span class="w-0.5 h-0.5 md:w-1 md:h-1 rounded-full bg-gray-200"></span><span>Size: {{ $item->size }}</span>@endif
                                                @if($item->color)<span class="w-0.5 h-0.5 md:w-1 md:h-1 rounded-full bg-gray-200"></span><span>Color: {{ $item->color }}</span>@endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 md:px-4 py-4 md:py-7 text-center font-bold text-[#707EAE] text-xs md:text-sm">৳{{ number_format($item->unit_price, 0) }}</td>
                                <td class="px-2 md:px-4 py-4 md:py-7 text-center">
                                    <span class="inline-block px-2 py-0.5 md:px-3 md:py-1 bg-[#F4F7FE] rounded-lg text-[10px] md:text-xs font-black text-[#4318FF]">{{ $item->quantity }}</span>
                                </td>
                                <td class="pr-6 md:pr-8 py-4 md:py-7 text-right font-black text-[#1B2559] text-sm md:text-lg">৳{{ number_format($item->total_price, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="mt-14 flex flex-col md:flex-row justify-between items-start gap-10">
                <div class="md:w-1/2 space-y-6">
                    <div>
                        <h4 class="text-xs font-black text-[#1B2559] tracking-[0.2em] uppercase mb-3">Terms & Validation</h4>
                        <p class="text-xs text-[#707EAE] leading-loose font-medium italic pr-10">
                            Thank you for your purchase. Please contact support within 24 hours for any modifications to this manifest.
                        </p>
                    </div>
                </div>

                <div class="md:w-[320px] bg-[#1B2559] rounded-[32px] p-8 space-y-4 shadow-xl totals-box">
                    <div class="flex justify-between items-center text-white/60 text-[10px] font-black uppercase tracking-widest">
                        <span class="text-white/60">Cart Subtotal</span>
                        <span class="text-white font-bold">৳{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-white/60 text-[10px] font-black uppercase tracking-widest">
                        <span class="text-white/60">Delivery Charge</span>
                        <span class="text-white font-bold">+৳{{ number_format($order->delivery_charge, 0) }}</span>
                    </div>
                    <div class="pt-4 border-t border-white/10 mt-2">
                        <div class="flex justify-between items-end">
                            <span class="text-white font-black font-outfit text-sm uppercase tracking-widest">Total Pay</span>
                            <span class="text-3xl font-black text-white font-outfit tracking-tighter">৳{{ number_format($order->total_amount, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Layer (Barcode & QR) -->
        <div class="bg-[#FBFDFF] p-8 md:p-14 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-10">
            <div class="text-center md:text-left space-y-3 md:space-y-4">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-1 md:mb-2">
                    <i class="fas fa-barcode text-[#1B2559] text-base md:text-xl"></i>
                    <span class="text-[9px] md:text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em]">Logistical identifier</span>
                </div>
                <div class="bg-white p-3 md:p-4 rounded-xl shadow-sm border border-gray-50 flex items-center justify-center">
                    <svg id="barcode"></svg>
                </div>
                <p class="text-[8px] md:text-[10px] text-[#A3AED0] font-bold uppercase">Scan to check inventory record</p>
            </div>

            <div class="h-10 md:h-24 w-px bg-gray-100 hidden md:block"></div>

            <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8">
                <div class="text-center md:text-right space-y-1">
                    <h4 class="text-xs md:text-sm font-black text-[#1B2559] font-outfit uppercase">Scan to Verify</h4>
                    <p class="text-[9px] md:text-[10px] text-[#707EAE] font-semibold max-w-[150px] md:max-w-[180px]">Instant digital verification and original document audit.</p>
                </div>
                <div class="bg-white p-2 md:p-3 rounded-2xl shadow-lg border-2 border-[#F4F7FE]">
                    <div id="qrcode"></div>
                </div>
            </div>
        </div>

        <div class="py-6 bg-[#1B2559] text-center print-hidden">
            <p class="text-white/40 text-[9px] font-black tracking-[0.4em] uppercase mb-1">Generated by {{ config('app.name') }} Financial Hub</p>
            <p class="text-white/20 text-[8px] italic">Copyright &copy; {{ date('Y') }} All Systems Nominal.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Generate Barcode
        JsBarcode("#barcode", "{{ $order->order_number }}", {
            format: "CODE128",
            width: 1.5,
            height: 40,
            displayValue: true,
            fontSize: 12,
            font: "Outfit",
            lineColor: "#1B2559",
            background: "transparent"
        });

        // Generate QR Code
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ url('/invoice/' . $order->order_number) }}",
            width: 80,
            height: 80,
            colorDark : "#1B2559",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        // PDF Download Function
        function downloadPDF() {
            const element = document.querySelector('.invoice-card');
            const options = {
                margin: 0,
                filename: 'Invoice-{{ $order->order_number }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            // Add loading state
            const btn = event.currentTarget;
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating...';
            btn.disabled = true;

            html2pdf().set(options).from(element).save().then(() => {
                btn.innerHTML = originalContent;
                btn.disabled = false;
            });
        }
        // Auto-download if 'download' parameter exists
        window.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('download')) {
                setTimeout(downloadPDF, 1500); // Small delay to ensure everything is ready
            }
        });
    </script>
</body>
</html>
