<template>
  <div class="container">
    <div v-if="!Next">
      <p>Product details</p>
      <input
        type="text"
        placeholder="Title"
        class="title"
        @input="input('title')"
      />
      <textarea
        placeholder="Description"
        class="descript"
        @input="input('descript')"
      ></textarea>
      <input
        type="date"
        placeholder="22/11/1998"
        class="date"
        @input="input('date')"
      />
      <b-button
        variant="primary"
        @click="next"
        style="margin-top: 10vh; float: right;"
        >Next</b-button
      >
    </div>
    <div v-if="Next">
      <p>Images gallery</p>
      <div class="mainDiv">
        <img class="mainImg" src="" alt="" />
        <div v-if="images.length" class="features">
          <input
            style="display: none;"
            class="editFile"
            type="file"
            name="photo"
            @change="edit"
            ref="imageEdit"
          />
          <button @click="$refs.imageEdit.click()" class="feture">
            <i class="fas fa-edit" style="font-size:24px"> </i>
          </button>
          <button @click="del" class="feture">
            <i class="fa fa-trash" style="font-size:24px"> </i>
          </button>
        </div>
      </div>
      <input
        style="display: none;"
        class="inpFile"
        type="file"
        name="photo"
        @change="onImageSelected"
        ref="imageInput"
      />
      <div class="row">
        <button @click="$refs.imageInput.click()" class="addImg">+</button>
        <div
          class="smallImg smallFirst"
          @click="makeMain('firstImg', 'smallFirst')"
        >
          <img class="firstImg sizeImg" src="" alt="" />
        </div>
        <div class="smallImg smallSec" @click="makeMain('secImg', 'smallSec')">
          <img class="secImg sizeImg" src="" alt="" />
        </div>
        <div
          class="smallImg smallThird"
          @click="makeMain('thirdImg', 'smallThird')"
        >
          <img class="thirdImg sizeImg" src="" alt="" />
        </div>
        <div
          class="smallImg smallFourth"
          @click="makeMain('fourthImg', 'smallFourth')"
        >
          <img class="fourthImg sizeImg" src="" alt="" />
        </div>
        <div
          class="smallImg smallFith"
          @click="makeMain('fithdImg', 'smallFith')"
        >
          <img class="fithImg sizeImg" src="" alt="" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Home",
  data() {
    return {
      Next: false,
      images: [],
      id: 0,
      PORT: `http://localhost:4000/phpServer`
    };
  },
  methods: {
    next() {
      let title = document.querySelector(".title");
      let description = document.querySelector(".descript");
      let date = document.querySelector(".date");
      if (title.value == "") {
        title.style.border = "1px solid red";
      } else {
        title.style.border = "1px solid lightgrey";
      }
      if (description.value == "") {
        description.style.border = "1px solid red";
      } else {
        description.style.border = "1px solid lightgrey";
      }
      if (date.value == "") {
        date.style.border = "1px solid red";
      } else {
        date.style.border = "1px solid lightgrey";
      }
      if (title.value != "" && description.value != "" && date.value !== "") {
        const payload = {
          gallery_titleֹ: title.value,
          gallery_description: description.value,
          gallery_date: date.value
        };
        this.$http
          .post(`${this.PORT}/index.php`, JSON.stringify(payload))
          .then(response => {
            if (response.data == 1) {
              this.Next = true;
            }
          });
      }
    },
    onImageSelected() {
      if (this.images.length < 5) {
        const inpFile = document.querySelector(".inpFile");
        const image = document.querySelector(".mainImg");
        const image1 = document.querySelector(".firstImg");
        const image2 = document.querySelector(".secImg");
        const image3 = document.querySelector(".thirdImg");
        const image4 = document.querySelector(".fourthImg");
        const image5 = document.querySelector(".fithImg");
        const image1Div = document.querySelector(".smallFirst");
        const image2Div = document.querySelector(".smallSec");
        const image3Div = document.querySelector(".smallThird");
        const image4Div = document.querySelector(".smallFourth");
        const image5Div = document.querySelector(".smallFith");
        const file = inpFile.files[0];
        if (!file.type.includes("image")) {
          alert("This file is not an image");
        } else if (file.size > 10000000) {
          alert("your image is bigger than 10mb");
        } else {
          const payload = {
            file_name: file.name,
            file_size: file.size,
            images_length: this.images.length
          };
          this.$http
            .post(`${this.PORT}/index.php`, JSON.stringify(payload))
            .then(response => {
              if (response.data == 1) {
                this.$http
                  .get(
                    `${this.PORT}/table.php?file_name=${file.name}&file_size=${file.size}&valid=Yes`
                  )
                  .then(response => {
                    /* eslint-disable no-console */
                    console.log(response);
                  });
                this.id = 0;
                const reader = new FileReader();
                reader.addEventListener("load", () => {
                  image.setAttribute("src", reader.result);
                  image1.setAttribute("src", reader.result);
                  this.images.unshift(reader.result);
                  switch (this.images.length) {
                    case 2:
                      image2.setAttribute("src", this.images[1]);
                      image2Div.style.display = "block";
                      break;
                    case 3:
                      image2.setAttribute("src", this.images[1]);
                      image3.setAttribute("src", this.images[2]);
                      image2Div.style.display = "block";
                      image3Div.style.display = "block";
                      break;
                    case 4:
                      image2.setAttribute("src", this.images[1]);
                      image3.setAttribute("src", this.images[2]);
                      image4.setAttribute("src", this.images[3]);
                      image2Div.style.display = "block";
                      image3Div.style.display = "block";
                      image4Div.style.display = "block";
                      break;
                    case 5:
                      image2.setAttribute("src", this.images[1]);
                      image3.setAttribute("src", this.images[2]);
                      image4.setAttribute("src", this.images[3]);
                      image5.setAttribute("src", this.images[4]);
                      image2Div.style.display = "block";
                      image3Div.style.display = "block";
                      image4Div.style.display = "block";
                      image5Div.style.display = "block";
                      break;
                  }
                });
                reader.readAsDataURL(file);
                image1Div.style.border = "1px solid black";
                image1Div.style.display = "block";
              }
            })
            .catch(error => {
              /* eslint-disable no-console */

              console.error(error);
            });
        }
      }
    },
    makeMain(imgName, divName) {
      const image = document.querySelector(".mainImg");
      const smallImage = document.querySelector(`.${imgName}`);
      const smallDiv = document.querySelector(`.${divName}`);
      const divs = document.querySelectorAll(".smallImg");
      for (let i = 0; i < divs.length; i++) {
        divs[i].style.border = "1px solid lightgrey";
        if (smallDiv == divs[i]) {
          this.id = i;
        }
      }
      smallDiv.style.border = "1px solid black";
      image.setAttribute("src", smallImage.src);
    },
    del() {
      const image = document.querySelector(".mainImg");
      const imgs = document.querySelectorAll(".sizeImg");
      const imgDivs = document.querySelectorAll(".smallImg");
      const image1Div = document.querySelector(".smallFirst");
      const image2Div = document.querySelector(".smallSec");
      const image3Div = document.querySelector(".smallThird");
      const image4Div = document.querySelector(".smallFourth");
      image1Div.style.border = "1px solid black";
      image2Div.style.border = "1px solid lightgrey";
      image3Div.style.border = "1px solid lightgrey";
      image4Div.style.border = "1px solid lightgrey";
      imgDivs[this.images.length - 1].style.display = "none";
      this.images.splice(this.id, 1);
      for (let i = 0; i < this.images.length + 1; i++) {
        imgs[i].src = this.images[i];
      }
      image.src = this.images[0];
      this.id = 0;
    },
    edit() {
      const inpFile = document.querySelector(".editFile");
      const image = document.querySelector(".mainImg");
      const imgs = document.querySelectorAll(".sizeImg");
      const file = inpFile.files[0];
      if (file.size < 10000000 && file.type.includes("image")) {
        const payload = {
          file_name: file.name,
          file_size: file.size
        };
        this.$http
          .post(`${this.PORT}/index.php`, JSON.stringify(payload))
          .then(response => {
            if (response.data == 1) {
              this.$http
                .get(
                  `${this.PORT}/table.php?file_name=${file.name}&file_size=${file.size}&valid=Yes`
                )
                .then(response => {
                  /* eslint-disable no-console */
                  console.log(response);
                });
              const reader = new FileReader();
              reader.addEventListener("load", () => {
                image.setAttribute("src", reader.result);
                this.images[this.id] = reader.result;
                imgs[this.id].src = reader.result;
              });
              reader.readAsDataURL(file);
            }
          });
      }
    },
    input(className) {
      const input = document.querySelector(`.${className}`);
      input.style.border = "1px solid lightgrey";
    }
  }
};
</script>
<style>
.container {
  margin-top: 10vh;
  height: 100vh;
}
.title {
  width: 72vw;
  border: 1px solid lightgrey;
}
.descript {
  width: 72vw;
  min-height: 50vh;
  margin-top: 2vh;
  border: 1px solid lightgrey;
}
.date {
  width: 72vw;
  border: 1px solid lightgrey;
}
.mainDiv {
  width: 52vw;
  height: 60vh;
  position: relative;
  border: 1px solid lightgrey;
}
.mainImg {
  margin-left: 1vw;
  margin-top: 1vh;
  max-width: 50vw;
  max-height: 48vh;
}
.features {
  height: 10vh;
  width: 49vw;
  position: absolute;
  bottom: 0;
  text-align: right;
}
.feture {
  background-color: white;
  border: none;
  margin-right: 1.5vw;
}
.row {
  display: flex;
  height: 6vh;
  margin-top: 5vh;
}
.addImg {
  width: 3vw;
  font-size: 26px;
  margin-left: 1vw;
  cursor: pointer;
  overflow: hidden;
}
.smallImg {
  width: 3vw;
  margin-left: 5vw;
  border: 1px solid lightgrey;
  cursor: pointer;
  display: none;
}
.sizeImg {
  margin: 0;
  width: 2.7vw;
  height: 5.5vh;
}
</style>
