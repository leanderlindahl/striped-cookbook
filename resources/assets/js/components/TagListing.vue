<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <button @click="initAddTag()" class="btn btn-outline-primary btn-xs float-right">
                    + Add New Tag
                </button>
                <h2>Tags</h2>

                <table class="table table-bordered table-striped table-responsive w-100 d-block d-md-table" v-if="tags.length > 0">
                    <tbody>
                        <tr>
                            <th>
                                No.
                            </th>
                            <th>
                                Name
                            </th>
                            <th width="20%">
                                Action
                            </th>
                        </tr>
                        <tr v-for="(tag, index) in tags">
                            <td>{{ index + 1 }}</td>
                            <td>
                                <!-- <router-link :to="`/tag/${tag.id}`"> -->
                                {{ tag.name }}
                                <!-- </router-link> -->
                            </td>
                            <td>
                                <button @click="initUpdate(index)" class="btn btn-outline-success btn-xs">Edit</button>
                                <!-- <button @click="deleteTag(index)" class="btn btn-outline-danger btn-xs">Delete</button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_tag_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add New Tag</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Tag Name" class="form-control" v-model="tag.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createTag" class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_tag_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Update Tag</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Recipe Name" class="form-control" v-model="update_tag.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateTag" class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
export default {
  data() {
    return {
      tag: {
        name: ""
      },
      errors: [],
      tags: [],
      update_tag: {}
    };
  },
  mounted() {
    this.readTags();
  },
  methods: {
    initAddTag() {
      $("#add_tag_model").modal("show");
    },
    createTag() {
      axios
        .post("/tag", {
          name: this.tag.name
        })
        .then(response => {
          this.reset();
          this.tags.push(response.data.tag);
          $("#add_tag_model").modal("hide");
        })
        .catch(error => {
          this.errors = [];
          if (error.response.data.errors.name) {
            this.errors.push(error.response.data.errors.name[0]);
          }
        });
    },
    reset() {
      this.tag.name = "";
    },
    readTags() {
      axios.get("/tag").then(response => {
        this.tags = response.data.tags;
      });
    },
    initUpdate(index) {
      this.errors = [];
      $("#update_tag_model").modal("show");
      this.update_tag = this.tags[index];
    },
    updateTag() {
      axios
        .patch("/tag/" + this.update_tag.id, {
          name: this.update_tag.name
        })
        .then(response => {
          $("#update_tag_model").modal("hide");
        })
        .catch(error => {
          this.errors = [];
          if (error.response.data.errors.name) {
            this.errors.push(error.response.data.errors.name[0]);
          }
        });
    },
    deleteTag(index) {
      let conf = confirm("Do you ready want to delete this tag?");
      if (conf === true) {
        axios
          .delete("/tag/" + this.tags[index].id)
          .then(response => {
            this.tags.splice(index, 1);
          })
          .catch(error => {});
      }
    }
  }
};
</script>