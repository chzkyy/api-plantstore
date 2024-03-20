<div class="education">
    <h1 class="organisasi">Experience</h3>
        @forelse ($experience as $item)
            <div class="education_container">
                <div class="education_time">
                    <span class="education_rounder"></span>
                    <span class="education_line"></span>
                </div>

                <div class="education_detail">
                    <h2 class="education_race">{{ $item->instansi }}</h2>
                    <p class="education_specialty">{{ $item->role }}</p>
                    <p class="education_year">{{ $item->year }}</p>
                </div>
            </div>
        @empty
            <div class="education_container">
                <div class="education_time">
                    <span class="education_rounder"></span>
                    <span class="education_line"></span>
                </div>

                <div class="education_detail">
                    <h2 class="education_race">No Experience</h2>
                    <p class="education_specialty"></p>
                    <p class="education_year"></p>
                </div>
            </div>
        @endforelse


</div>
