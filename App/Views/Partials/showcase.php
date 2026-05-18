  <!-- Showcase -->
      <section
        class="showcase relative bg-cover bg-center bg-no-repeat h-72 flex items-center"
        style="background-image: linear-gradient(rgba(15,23,42,0.35), rgba(15,23,42,0.35)), url('<?= asset('images/showcase.jpg') ?>');"
      >
        <div class="overlay"></div>
        <div class="container mx-auto text-center z-10">
          <h2 class="text-4xl text-white font-bold mb-4" data-animate="hero">Find Your Dream Job</h2>
          <form method="GET" action="<?= url('listings/search') ?>" class="mb-4 block mx-5 md:mx-auto" data-animate="fade">
            <input
              type="text"
              name="keywords"
              placeholder="Keywords"
              class="w-full md:w-auto mb-2 px-4 py-2 focus:outline-none rounded-lg box-shadow-md"
            />
            <input
              type="text"
              name="location"
              placeholder="Location"
              class="w-full md:w-auto mb-2 px-4 py-2 focus:outline-none rounded-lg box-shadow-md"
            />
            <button
              class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 focus:outline-none" data-animate="pop"
            >
            <i class="fa fa-search"></i> Search
            </button>
          </form>
        </div>
      </section>