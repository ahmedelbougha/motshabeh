function generateRandom(min = 0, max = 100) {
  // find diff
  let difference = max - min;

  // generate random number
  let rand = Math.random();

  // multiply with difference
  rand = Math.floor(rand * difference);

  // add with min value
  rand = rand + min;

  return rand;
}

function getQuestion(surah, juz, similarOnly = false, remove = false) {
  const length = generateRandom(2, 6);
  const edge = generateRandom(1, 3);
  let forcedVerse;

  if (!similarOnly) {
    const randomIndex = generateRandom(0, verses.length - 1);
    forcedVerse = verses[randomIndex];
  }

  const similar = getSimilarity(
    verses,
    length,
    edge,
    surah,
    juz,
    remove,
    forcedVerse
  );
  const similarIndex = generateRandom(0, similar.length);
  console.log(similar);
  return {
    question: similar[similarIndex].same,
    fullAnswer: similar[similarIndex],
  };
}

function displayQuestion(
  questionDev,
  resultDev,
  surah,
  juz,
  similarOnly = false,
  remove = false
) {
  const { question, fullAnswer } = getQuestion(surah, juz, similarOnly, remove);
  displayQuestionContent(questionDev, resultDev, question, fullAnswer);
}

function displayQuestionContent(questionDev, resultsDiv, question, fullAnswer) {
  let questionFinal = `<div class="alert alert-primary">أكمل: ${question}</div>`;

  let answerFinal = `<div class="alert alert-success">`;
  answerFinal += `<p class="text-primary">${question}: ${fullAnswer.ids.size} متشابهة</p>`;
  answerFinal += `<p class="text-danger">أرقام الأيات: ${Array.from(
    fullAnswer.ids
  ).join("، ")}</p>`;
  answerFinal += `<p>${Array.from(fullAnswer.full).join("<br/>\n")}</p>`;
  answerFinal += `</div>`;

  document.querySelector(questionDev).innerHTML = questionFinal;
  document.querySelector(resultsDiv).innerHTML = answerFinal;
}

function getSimilarity(
  verses,
  length,
  edge = "1",
  surah = "2",
  juz = "1",
  remove = false,
  forcedVerse = undefined
) {
  let similar = [];
  let cached = [];
  let juzNum = "";
  const end = edge == "1" ? false : true;
  if (juz !== "all") {
    juzNum = juz;
  }

  // this object shall carry the comparison similarity
  let compare = {
    same: [],
    ids: new Set(),
    full: new Set(),
  };

  for (let v = 0; v < verses.length; v++) {
    if (
      cached.includes(verses[v].id) ||
      (forcedVerse && forcedVerse.id == verses[v].id)
    ) {
      continue;
    }

    // exit in case it reaches the last verse
    if (v >= verses.length - 1) break;

    // in case comparison is forced for one verse
    if (forcedVerse) {
      verseCompare(
        cached,
        verses[v],
        forcedVerse,
        compare,
        length,
        edge == "1" ? false : true,
        surah,
        juzNum,
        remove
      );
    } else {
      // reset the comparison object on each new verse to compare
      // so we start fresh comparison
      compare = {
        same: [],
        ids: new Set(),
        full: new Set(),
      };

      for (let i = v + 1; i < verses.length; i++) {
        verseCompare(
          cached,
          verses[v],
          verses[i],
          compare,
          length,
          end,
          surah,
          juzNum,
          remove
        );
      }
    }

    if (compare.same.length > 0) {
      similar.push(compare);
    }
  }

  // in case a verse is selected randomly and there's no similarity with another verse
  // forcibly add the verse into similarities array
  if (similar.length === 0 && forcedVerse) {
    let phrase = formPhrase(forcedVerse, length, end, false);

    let compare = {
      same: [phrase],
      ids: new Set(),
      full: new Set(),
    };

    addToComparison(compare, cached, forcedVerse);
    similar.push(compare);
  }
  return similar;
}

function displaySimilarity(
  resultsDiv,
  length,
  edge = "1",
  surah = "2",
  juz = "1",
  remove = false
) {
  const selectedVerses = verses;
  const similar = getSimilarity(selectedVerses, length, edge, surah, juz);
  displaySimilarityContent(resultsDiv, edge, similar);
}

function displaySimilarityContent(resultsDiv, edge, similar) {
  const location = edge == 1 ? "اوائل" : "آواخر";
  let final = `<div class="alert alert-primary">المتشابهات في ${location} الآيات: ${similar.length}</div>`;
  let conclusion = "<br>";
  for (let verse of similar) {
    final += `<div class="alert alert-success">`;
    final += `<p class="text-primary">${verse.same}: ${verse.ids.size} متشابهة</p>`;
    final += `<p class="text-danger">أرقام الأيات: ${Array.from(verse.ids).join(
      "، "
    )}</p>`;
    final += `<p>${Array.from(verse.full).join("<br/>\n")}</p>`;
    final += `</div>`;
    // conclusion += `${verse.same}<br/>`
  }

  document.querySelector(resultsDiv).innerHTML = final + conclusion;
}

function verseCompare(
  cached,
  v1,
  v2,
  compare,
  length,
  end = false,
  surah = "2",
  juzNum = "",
  remove = false
) {
  // don't do anything if the verse is already in the cached
  if (cached.includes(v1.id) && cached.includes(v2.id)) {
    return;
  }

  let condition;
  phrase1 = formPhrase(v1, length, end, remove);
  phrase2 = formPhrase(v2, length, end, remove);



  condition = phrase1 == phrase2;

  if (surah) {
    condition = condition && v1.surah.id == surah && v2.surah.id == surah;
  }

  if (juzNum) {
    condition = condition && v1.juz == juzNum && v2.juz == juzNum;
  }

  if (condition) {
    compare.same = phrase1;
    if (v1.id < v2.id) {
      addToComparison(compare, cached, v1);
      addToComparison(compare, cached, v2);
    } else {
      addToComparison(compare, cached, v2);
      addToComparison(compare, cached, v1);
    }
  }
}

function addToComparison(compare, cached, verse) {
  compare.ids.add(verse.id);
  compare.full.add(
    (
      verse.words.join(" ") +
      ` <span class="text-danger">(${
        verse.num
      })</span> <button type="button" class="show-verse btn btn-sm btn-danger" onclick="showVerse(${
        verse.id + 1
      })">التالية</button>`
    ).replace(compare.same, `<span class="text-primary">${compare.same}</span>`)
  );
  cached.push(verse.num);
}

function removeExtraChars(phrase) {
  const removals = /^(ب|و|ف)/;
  const finalPhrase = phrase.replace(removals, "");
  return finalPhrase;
}

function getVerse(id) {
  const verse = verses.filter((v) => v.id == id);
  // console.log('verse', id, verse[0])
  return verse[0]?.words?.join(" ");
}

function showVerse(id) {
  const verseModal = new bootstrap.Modal(
    document.querySelector("#verse-modal"),
    {
      keyboard: false,
    }
  );
  const verseContent = getVerse(id);
  document.querySelector("#verse-modal-content").innerHTML = verseContent;
  verseModal.show();
}

function formPhrase(verse, length, end, remove) {
  let phrase = end
    ? verse.words.slice(-length).join(" ")
    : verse.words.slice(0, length).join(" ");
  // special case:
  // if the similar phrases is taken from end and starts with the word Allah
  // take the one extra word before it to avoid change of the meaning example
  // وما الله بغافل عما تعملون
  if (end && phrase.startsWith('الله')) {
    phrase = verse.words.slice(-length-1).join(" ");
  }

  if (remove) {
    phrase = removeExtraChars(phrase);
  }

  return phrase;
}
