class QuestionBox {
  constructor(option = {}) {
    this.__el = option.el ? option.el : document.querySelector(option.selector);
    if (!this.__el) throw Error("element not found");
    this.__boxAction = this.__el.querySelector(".box-action");

    //prepare actin
    this.__applyAction();
  }

  __applyAction() {
    this.__boxAction.addEventListener("click", () => {
      this.__el.classList.toggle("expand");
      this.__boxAction.querySelector("img").classList.toggle("rotate-180");
    });
  }
}


(() => {
    const listQuestionBox = [];
    document
      .querySelectorAll(".question-box")
      .forEach((el) => listQuestionBox.push(new QuestionBox({ el })));
    window.$app = Object.assign(window.$app || {}, { listQuestionBox });
})()
