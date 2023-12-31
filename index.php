<!DOCTYPE html>
<html lang="ar" dir="rtl">
<style>
  /* .show-verse {
    left: 0px;
    position: absolute;
    margin-left: 5px;
  } */
  #results,
  #questionAnswer {
    line-height: 2rem;
  }
</style>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>متشابهات القرآن الكريم</title>
  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>

  <div class="container-fluid">
    <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
      <div class="col-md-6 px-0">
        <h1 class="display-4 fst-italic">متشابهات القرآن الكريم</h1>
        <p class="lead my-3">نسخة تجريبية.</p>
      </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
          role="tab" aria-controls="home" aria-selected="true">الرئيسية</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions" type="button"
          role="tab" aria-controls="questions" aria-selected="false">اختبر نفسك</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div id="top" class="row">
          <div class="col-md-6">
            <label for="length" class="form-label">عدد الكلمات:</label>
            <select id="length" name="length" class="form-select">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="edge" class="form-label">موقع الكلمات:</label>
            <select id="edge" name="edge" class="form-select">
              <option value="1">بدايات الآيات</option>
              <option value="2">نهايات الآيات</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label for="surah" class="form-label">السورة:</label>
            <select id="surah" name="surah" class="form-select">
              <option value="1">الفاتحة</option>
              <option value="2">البقرة</option>
              <option value="3">آل عمران</option>
              <option value="4">النساء</option>
              <option value="5">المائدة</option>
              <option value="6">الأنعام</option>
              <option value="7">الأعراف</option>
              <option value="8">الأنفال</option>
              <option value="9">التوبة</option>
              <option value="10">يونس</option>
              <option value="11">هود</option>
              <option value="12">يوسف</option>
              <option value="13">الرعد</option>
              <option value="14">إبراهيم</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="juz" class="form-label">الجزء:</label>
            <select id="juz" name="juz" class="form-select">
              <option value="all">الكل</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
            </select>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-6">
            <label for="remove" class="form-label">حذف الحروف الزائدة(بـ، فـ، و):</label>
            <input type="checkbox" id="remove" name="remove" value="1" />
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-primary" onclick="show()">اعرض</button>
          </div>
        </div>
        <hr>
        <div id="results" class="container"></div>
      </div>
      <div class="tab-pane fade" id="questions" role="tabpanel" aria-labelledby="profile-tab">
        <div class="row">
          <div class="col-md-6">
            <label for="quesSurah" class="form-label">السورة:</label>
            <select id="quesSurah" name="quesSurah" class="form-select">
              <option value="all">اختر عشوائيا</option>
              <option value="1">الفاتحة</option>
              <option value="2">البقرة</option>
              <option value="3">آل عمران</option>
              <option value="4">النساء</option>
              <option value="5">المائدة</option>
              <option value="6">الأنعام</option>
              <option value="7">الأعراف</option>
              <option value="8">الأنفال</option>
              <option value="9">التوبة</option>
              <option value="10">يونس</option>
              <option value="11">هود</option>
              <option value="12">يوسف</option>
              <option value="13">الرعد</option>
              <option value="14">إبراهيم</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="quesJuz" class="form-label">الجزء:</label>
            <select id="quesJuz" name="quesJuz" class="form-select">
              <option value="all">الكل</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
            </select>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-6">
            <label for="similarOnly" class="form-label">المتشابهات فقط:</label>
            <input type="checkbox" id="similarOnly" name="similarOnly" value="1" />
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-primary" onclick="showَQuestion()">اعرض السؤال</button>
          </div>
        </div>
        <hr>
        <div id="questionBody" class="container"></div>
        <div class="accordion d-none" id="verseAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                الإجابة
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div id="questionAnswer" class="container"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="verse-modal" class="modal fade" aria-hidden="true" aria-labelledby="verse-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h5 id="modal-title" class="modal-title">الآية</h5>
        </div>
        <div class="modal-body">
          <p id="verse-modal-content"></p>
        </div>
      </div>
    </div>
  </div>

  <script src="bootstrap.min.js"></script>
  <script src="verses.js"></script>
  <script src="scripts.js"></script>
  <script>
    function show() {
      const q = document.querySelector;
      displaySimilarity('#results',
        document.querySelector('#length').value,
        document.querySelector('#edge').value,
        document.querySelector("#surah").value,
        document.querySelector("#juz").value,
        document.querySelector("#remove").checked
      );
    }

    function showَQuestion() {
      displayQuestion('#questionBody', '#questionAnswer',
        document.querySelector("#quesSurah").value,
        document.querySelector("#quesJuz").value,
        document.querySelector("#similarOnly").checked);
      document.querySelector('#verseAccordion').classList.remove('d-none');
    }
  </script>
</body>

</html>